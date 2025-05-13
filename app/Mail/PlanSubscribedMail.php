<?php

namespace App\Mail;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanSubscribedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Plan $plan;
    public string $startDate;
    public string $endDate;


    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Plan $plan, string $startDate, string $endDate)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Activated: ' . $this->plan->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.plan.subscribed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
