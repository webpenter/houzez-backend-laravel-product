<?php

namespace App\Http\Controllers\EmailManagement;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\EmailAttachment;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class EmailController extends Controller
{
    /**
     * Compose and send email using selected template.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'template_slug'  => 'required|string|exists:email_templates,slug',
            'to_email'       => 'required|array|min:1',
            'to_email.*'     => 'email',
            'cc_email'       => 'nullable|array',
            'bcc_email'      => 'nullable|array',
            'placeholders'   => 'nullable|array', // {{name}}, {{link}}, etc.
            'attachments.*'  => 'file|max:5120',
        ]);

        $template = EmailTemplate::where('slug', $validated['template_slug'])->firstOrFail();
        $userId = Auth::id();

        // Replace placeholders dynamically
        $content = $template->content;
        if (!empty($validated['placeholders'])) {
            foreach ($validated['placeholders'] as $key => $value) {
                $content = str_replace('{{' . $key . '}}', e($value), $content);
            }
        }

        // Save draft first
        $email = Email::create([
            'template_id' => $template->id,
            'to_email'    => json_encode($validated['to_email']),
            'cc_email'    => json_encode($validated['cc_email'] ?? []),
            'bcc_email'   => json_encode($validated['bcc_email'] ?? []),
            'subject'     => $template->subject,
            'content'     => $content,
            'status'      => 'queued',
            'created_by'  => $userId,
        ]);

        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments', 'public');
                EmailAttachment::create([
                    'email_id' => $email->id,
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
            }
        }

        // Send email
        try {
            Mail::send([], [], function ($message) use ($validated, $template, $content, $email) {
                $message->to($validated['to_email'])
                        ->subject($template->subject)
                        ->setBody($content, 'text/html');

                if (!empty($validated['cc_email'])) {
                    $message->cc($validated['cc_email']);
                }

                if (!empty($validated['bcc_email'])) {
                    $message->bcc($validated['bcc_email']);
                }

                foreach ($email->attachments as $attachment) {
                    $message->attach(storage_path("app/public/{$attachment->path}"));
                }
            });

            // Log event
            EmailLog::create([
                'email_id' => $email->id,
                'recipient' => implode(',', $validated['to_email']),
                'event' => 'sent',
                'provider_response' => 'Mail sent successfully',
                'meta' => json_encode(['subject' => $template->subject]),
                'created_at' => now(),
            ]);

            $email->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully!',
                'data' => $email,
            ]);
        } catch (Exception $e) {
            $email->update([
                'status' => 'failed',
                'fail_reason' => $e->getMessage(),
            ]);

            EmailLog::create([
                'email_id' => $email->id,
                'event' => 'failed',
                'provider_response' => $e->getMessage(),
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Email sending failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
