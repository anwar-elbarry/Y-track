<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    
    /**
     * Create a new message instance.
     */
    public function __construct(invoice $invoice)
    {
        $this->invoice = Invoice::with(['client', 'user'])->find($invoice->id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice #' . $this->invoice->id,
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Invoice System')),
            replyTo: [env('MAIL_FROM_ADDRESS')]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
            with: [
                'invoice' => $this->invoice
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Debug data before PDF generation
        \Log::info('Generating PDF attachment', [
            'invoice_id' => $this->invoice->id,
            'client_name' => $this->invoice->client->name,
            'user_name' => $this->invoice->user->name
        ]);

        // Prepare view data
        $data = [
            'invoice' => $this->invoice,
            'client' => $this->invoice->client,
            'user' => $this->invoice->user
        ];

        // Generate PDF
        $pdf = PDF::loadView('invoices.pdf', $data);
        $pdf->setPaper('A4');
        
        return [
            Attachment::fromData(fn () => $pdf->output(), 'invoice.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
