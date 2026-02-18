<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'invoice_date' => 'date',
        'issued_date' => 'date',
        'paid_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function installments()
    {
        return $this->belongsToMany(
            Installment::class,
            'invoice_installments'
        )->withPivot([
            'amount_paid',
            'commission_rate',
            'commission_amount',
            'net_amount',
            'collected_type'
        ])->withTimestamps();
    }
}
