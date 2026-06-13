<?php

namespace App\Mail;

use App\Models\Conge;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CongeStatutMisAJour extends Mailable
{
    use Queueable, SerializesModels;

    public $conge;

    /**
     * Create a new message instance.
     */
    public function __construct(Conge $conge)
    {
        $this->conge = $conge;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statut = $this->conge->statut === 'valide' ? 'Validée' : 'Refusée';
        return new Envelope(
            subject: 'Votre demande de congé a été ' . $statut,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.conges.statut',
        );
    }
}
