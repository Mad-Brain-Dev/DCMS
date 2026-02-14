<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'role',
        'commission_rate',
        ];
    public function commissions()
    {
        return $this->hasMany(EmployeeCommission::class,'employee_id');
    }

    public function payments()
    {
        return $this->hasMany(EmployeePayment::class,'employee_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
