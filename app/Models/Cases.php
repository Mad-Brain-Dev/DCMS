<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
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
        'debtor_id',
        'amount_owed',
        'case_type',
        'case_status',
        'case_priority',
        'due_date',
    ];

    public function debtor()
    {
        return $this->belongsTo(User::class);
    }

}
