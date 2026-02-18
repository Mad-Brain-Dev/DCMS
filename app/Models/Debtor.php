<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'debtor_id');
    }
}
