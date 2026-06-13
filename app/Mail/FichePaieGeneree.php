<?php

namespace App\Mail;

use App\Models\FichePaie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FichePaieGeneree extends Mailable
{
    use Queueable, SerializesModels;

    public $fiche;

    /**
     * Create a new message instance.
     */
    public function __construct(FichePaie $fiche)
    {
        $this->fiche = $fiche;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre fiche de paie de ' . $this->fiche->mois->translatedFormat('F Y') . ' est disponible',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.paie.generee',
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
