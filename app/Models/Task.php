<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Installment;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'installment_id',
        'assign_type'
    ];
    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
