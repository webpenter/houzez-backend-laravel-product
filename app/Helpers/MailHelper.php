<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class MailHelper
{
    /**
     * Send an email using a Mailable class
     *
     * @param string|array $to - Recipient email(s)
     * @param \Illuminate\Mail\Mailable $mailable - Mailable instance
     * @return bool
     */
    public static function sendMail(string|array $to, Mailable $mailable): bool
    {
        try {
            Mail::to($to)->send($mailable);
            return true;
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a raw email without creating a Mailable class
     *
     * @param string|array $to
     * @param string $subject
     * @param string $message
     * @param array $attachments
     * @return bool
     */
    public static function sendRawMail(string|array $to, string $subject, string $message, array $attachments = []): bool
    {
        try {
            Mail::send([], [], function ($mail) use ($to, $subject, $message, $attachments) {
                $mail->to($to)
                     ->subject($subject)
                     ->setBody($message, 'text/html');

                foreach ($attachments as $file) {
                    $mail->attach($file);
                }
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Raw mail sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
