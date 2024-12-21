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
        'assign_type',
        'fv_date',
       ' status',
        'date_of_payment',
        'collected_by_id',
        'collection_date'
    ];
    public function case()
    {
        return $this->belongsTo(Cases::class,'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'collected_by_id');
    }

}
