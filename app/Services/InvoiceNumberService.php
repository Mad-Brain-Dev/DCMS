<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function generate($client)
    {
        return DB::transaction(function () use ($client) {

            $year = now()->year;

            $lastInvoice = Invoice::where('client_id', $client->id)
                ->where('year', $year)
                ->lockForUpdate()
                ->orderByDesc('sequence_number')
                ->first();

            $nextSequence = $lastInvoice
                ? $lastInvoice->sequence_number + 1
                : 1;

            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

            $invoiceNumber = "INV-{$client->abbr}-{$year}-{$formattedSequence}";

            return [
                'invoice_number' => $invoiceNumber,
                'year' => $year,
                'sequence_number' => $nextSequence,
            ];
        });
    }
}

