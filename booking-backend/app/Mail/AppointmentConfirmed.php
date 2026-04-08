<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Confirmed - KapoBarber',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: '<h2>Appointment Confirmed!</h2><p>Dear ' . $this->appointment->user->name . ',</p><p>Your appointment with <strong>' . ($this->appointment->barber->name ?? 'our barber') . '</strong> is scheduled for <strong>' . $this->appointment->date . '</strong> at <strong>' . \Carbon\Carbon::parse($this->appointment->time)->format('H:i') . '</strong>.</p><p>Thank you for choosing KapoBarber!</p>'
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
