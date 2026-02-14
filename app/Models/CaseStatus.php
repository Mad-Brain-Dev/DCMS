<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'table_row_color',
        'bg_color',
        'value',
    ];
}
