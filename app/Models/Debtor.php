<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    protected $table = 'debtors';
    protected $fillable = [
        'case_id',
        'name',
        'nric',
        'phone',
        'email',
        'address',
        'remarks',
    ];

    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }
}
