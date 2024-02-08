<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrespondenceUpdate extends Model
{
    use HasFactory;
    public const FILE_STORE_DOCUMENT_PATH = 'document';
    protected $fillable = [
        'cr_update',
        'case_id',
    ];
}
