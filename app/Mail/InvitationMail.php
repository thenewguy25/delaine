<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invitation $invitation;

    /**
     * Create a new message instance.
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = config('registration.email.subject', 'You\'re invited to join :app_name');
        $subject = str_replace(':app_name', config('app.name'), $subject);

        return new Envelope(
            subject: $subject,
            from: config('registration.email.from_email', config('mail.from.address')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: [
                'invitation' => $this->invitation,
                'registrationUrl' => $this->getRegistrationUrl(),
                'expiryDate' => $this->invitation->expires_at->format('M d, Y \a\t H:i'),
                'appName' => config('app.name'),
            ],
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

    /**
     * Get the registration URL for the invitation.
     */
    private function getRegistrationUrl(): string
    {
        return route('register', [
            'token' => $this->invitation->token,
            'email' => $this->invitation->email,
        ]);
    }
}
