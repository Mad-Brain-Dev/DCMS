<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Installment;
use Symfony\Component\Translation\Test\ProviderFactoryTestCase;

class Cases extends Model
{
    use HasFactory;
    public const CASE_TYPE_OUTSTANDING_LOAN    = 'Outstanding Loan';
    public const CASE_TYPE_UNPAID_BILLS    = 'Unpaid Bills';
    public const CASE_STATUS_OPEN    = 'Open';
    public const CASE_STATUS_CLOSED    = 'Closed';
    public const CASE_STATUS_IN_PROGRESS    = 'In Progress';
    public const CASE_STATUS_RESOLVED   = 'Resolved';
    public const CASE_PRIORITY_HIGH   = 'High';
    public const CASE_PRIORITY_MEDIUM   = 'Medium';
    public const CASE_PRIORITY_LOW   = 'Low';
    protected $fillable = [
        'case_number',
        'remarks',
        'case_sku',
        'case_summary',
        'current_status',
        'date_of_warrant',
        'client_id',
        'user_id',
        'collection_commission',
        'field_visit',
        'bal_field_visit',
        'manager_ic',
        'collector_ic',
        'name',
        'nric' ,
        'company_name',
        'company_uen',
        'phone',
        'email',
        'adderss',
        'fv_date',
        'debt_amount',
        'legal_cost',
        'debt_interest',
        'guarantor_name',
        'guarantor_address',
        'guarantor_name2',
        'guarantor_address2',
        'guarantor_name3',
        'guarantor_address3',
        'interest_start_date',
        'interest_end_date',
        'total_interest',
        'total_amount_owed',
        'total_amount_paid',
        'total_amount_balance',
        'payment_method',
        'next_payment_date',
        'next_payment_amount',
        'payment_date',

    ];

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function clientDetails(){
        return $this->belongsTo(Client::class);
    }

    public function getUser()
    {
        return $this->hasOneThrough(User::class, Client::class);
    }
    public function installments()
    {
        return $this->hasMany(Installment::class, 'case_id');
    }

}
