<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cases;

class Installment extends Model
{
    use HasFactory;
    protected $fillable = [
        'case_id',
        'amount_paid',
        'next_payment_amount',
        'next_payment_date',
        'payment_method',
        'date_of_payment'
    ];
    public function case()
    {
        return $this->belongsTo(Cases::class,'case_id');
    }
}
