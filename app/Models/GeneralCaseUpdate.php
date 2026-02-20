<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralCaseUpdate extends Model
{
    use HasFactory;
    public const FILE_STORE_DOCUMENT_PATH = 'document';
    protected $fillable = [
        'gn_update',
        'fv_date',
        'gn_summary',
        'amount_paid',
        'case_id',
        'remarks',
        'installment_id'
    ];

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class,'installment_id');
    }
}
