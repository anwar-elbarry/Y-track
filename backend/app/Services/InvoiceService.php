<?php

namespace App\Services;

use App\Models\invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    public function SendInvoice(object $invoice)
    {
        // Validate invoice
        if (!$invoice || !$invoice->client || !$invoice->client->email) {
            throw new \InvalidArgumentException('Invalid invoice or client information');
        }
        try {
            // Load the invoice with relationships
            $invoice = Invoice::with(['client', 'user'])->find($invoice->id);
            
            // Debug the data before PDF generation
            \Log::info('Invoice Data before PDF generation', [
                'invoice_id' => $invoice->id,
                'client' => $invoice->client->toArray(),
                'user' => $invoice->user->toArray(),
                'service_name' => $invoice->service_name,
                'service_description' => $invoice->service_description,
                'service_price' => $invoice->service_price
            ]);

            // Prepare view data
            $data = [
                'invoice' => $invoice,
                'client' => $invoice->client,
                'user' => $invoice->user
            ];

            // Generate PDF using view data
            $pdf = PDF::loadView('invoices.pdf', $data);
            $pdf->setPaper('A4');
            
            // Store PDF
            $filePath = 'invoices/invoice_' . $invoice->id . '.pdf';
            Storage::disk('public')->put($filePath, $pdf->output());

            // Update database
            $invoice->update([
                'invoice_path' => $filePath,
            ]);

            // Send email
            Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));

            return $filePath;
        } catch(\Exception $e) {
            \Log::error('Error in invoice process: ' . $e->getMessage(), [
                'invoice_id' => $invoice->id ?? null,
                'error' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    public function createInvoice(array $data){
        $invoice = Invoice::create($data);
        if($invoice){
            return $invoice;
        }
        return false;
    }
    public function updateInvoice($data){
        $invoice = Invoice::find($data['id']);
        if($invoice){
            $invoice->update($data);
            return $invoice;
        }
        return false;
    }
    public function deleteInvoice($id){
        $invoice = Invoice::find($id);
        if($invoice){
            $invoice->delete();
            return true;
        }
        return false;
    }
    public function getInvoice($id){
        $invoice = Invoice::find($id);
        if($invoice){
            return $invoice;
        }
        return false;
    }
    public function getAllInvoices(){
        $invoices = Invoice::all();
        if($invoices){
            return $invoices;
        }
        return false;
    }
}
