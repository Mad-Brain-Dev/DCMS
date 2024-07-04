<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'admin_fee_amount',
        'collection_date',
        'collected_by'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'collected_by_id');
    }
}
