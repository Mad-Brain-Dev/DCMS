<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldVisitUpdate extends Model
{
    use HasFactory;
    public const FILE_STORE_DOCUMENT_PATH = 'document';
    protected $fillable = [
        'fv_update',
        'case_id',
        'fv_summary',
        'fv_date',
        'remarks',
        'installment_id',
        'update_type'
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class,'installment_id');
    }
}
