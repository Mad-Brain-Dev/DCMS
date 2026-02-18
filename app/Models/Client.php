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
        'collection_commission',
        'date_of_agreement',
        'date_of_expiry',
        'admin_fee',
        'admin_fee_paid',
        'admin_fee_balance',
        'field_visit_per_case',
        'pic_name',
        'pic_number',
        'pic_email',
        'account_name',
        'bank_name',
        'account_number',
        'bank_code',
        'branch_code',
        'bank_address',
        'swift_code',
        'payment_methods',
    ];

    public function cases()
    {
        return $this->hasMany(Cases::class);
    }

    public function adminFee()
    {
        return $this->hasMany(AdminFee::class,'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
