<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $casts = [
        'date_of_agreement ' => 'datetime:Y-m-d',
      ];
    protected $fillable = [
        'name',
        'abbr',
        'user_id',
        'nric',
        'company_name',
        'company_uen',
        'email',
        'phone' ,
        'address',
        'date_of_agreement',
        'date_of_expiry',
        'admin_fee',
        'admin_fee_paid',
        'admin_fee_balance',
        'administrative_fee',
        'enforcement_fee',
        'professional_fee',
        'annual_fee',
        'skip_tracing_fee',
        'overseas_allowance',
        'collection_commission',
        'field_visit_per_case',
    ];

    public function cases()
    {
        return $this->hasMany(Cases::class);
    }
}
