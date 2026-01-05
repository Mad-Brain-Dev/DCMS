<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Installment extends Model
{
    use HasFactory;
    protected $fillable = [
        'case_id',
        'amount_paid',
        'next_payment_amount',
        'next_payment_date',
        'payment_method',
        'assign_type',
        'fv_date',
        'update_type',
       ' status',
        'date_of_payment',
        'collected_by_id',
        'collection_date',
        'underInstallment',
        'pay_to_who',
    ];

    protected $casts = [
        'next_payment_date' => 'date',
    ];
    public function case()
    {
        return $this->belongsTo(Cases::class,'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'collected_by_id');
    }

    public function fvUpdates()
    {
        return $this->hasMany(FieldVisitUpdate::class,'installment_id');
    }

    public function paymentStatus()
    {
        // Must have expected amount and date
        if ($this->next_payment_amount === null || $this->date_of_payment === null) {
            return ['label'   => 'Pending',
                'class'   => 'secondary',
                'tooltip' => 'No next payment has been recorded yet.'];
        }

        // VERY NEXT installment (business-safe + time-safe)
        $next = self::where('case_id', $this->case_id)
            ->where('update_type', 'field_visit_update')
            ->whereNotNull('amount_paid')
            ->where(function ($q) {
                $q->where('date_of_payment', '>', $this->date_of_payment)
                    ->orWhere(function ($q2) {
                        $q2->where('date_of_payment', $this->date_of_payment)
                            ->where('created_at', '>', $this->created_at);
                    });
            })
            ->orderBy('date_of_payment', 'asc')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();

//        for debuging
//        return [
//            'label' => 'DEBUG',
//            'class' => 'dark',
//            'debug' => [
//                'current_id'   => $this->id,
//                'current_time' => $this->date_of_payment,
//                'expected'     => $this->next_payment_amount,
//                'next_id'      => optional($next)->id,
//                'next_time'    => optional($next)->date_of_payment,
//                'next_paid'    => optional($next)->amount_paid,
//            ],
//        ];
        // No next installment → Pending
        if (!$next) {
            return ['label'   => 'Pending',
                'class'   => 'secondary',
                'tooltip' => 'No next payment has been recorded yet.'];
        }

        $expected = (float) $this->next_payment_amount;
        $paid     = (float) $next->amount_paid;

        if ($paid == $expected) {
            return [
                'label'   => 'Paid',
                'class'   => 'success',
                'tooltip' => 'Next payment exactly matched the expected amount.'
            ];
        }

        if ($paid < $expected) {
            return [
                'label'   => 'Partially Paid',
                'class'   => 'warning',
                'tooltip' => 'Next payment was less than the expected amount.'
            ];
        }

        return [
            'label'   => 'Over Paid',
            'class'   => 'info',
            'tooltip' => 'Next payment was greater than the expected amount.'
        ];
    }

    public function nextPaymentDateStatus()
    {
        if (!$this->next_payment_date || !$this->date_of_payment) {
            return [
                'label' => 'Pending',
                'class' => 'secondary',
                'tooltip' => 'No next payment has been recorded yet.'
            ];
        }

        $next = self::where('case_id', $this->case_id)
            ->where('update_type', 'field_visit_update')
            ->where(function ($q) {
                $q->where('date_of_payment', '>', $this->date_of_payment)
                    ->orWhere(function ($q2) {
                        $q2->where('date_of_payment', $this->date_of_payment)
                            ->where('id', '>', $this->id);
                    });
            })
            ->orderBy('date_of_payment', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        if (!$next) {
            return [
                'label' => 'Pending',
                'class' => 'secondary',
                'tooltip' => 'No next payment has been recorded yet.'
            ];
        }

        $expectedDate = \Carbon\Carbon::parse($this->next_payment_date)->startOfDay();
        $actualDate   = \Carbon\Carbon::parse($next->date_of_payment)->startOfDay();

        if ($actualDate->equalTo($expectedDate)) {
            return [
                'label' => 'On Time',
                'class' => 'success',
                'tooltip' => 'Payment was made on the expected date.'
            ];
        }

        if ($actualDate->lessThan($expectedDate)) {
            return [
                'label' => 'Early',
                'class' => 'info',
                'tooltip' => 'Payment was made before the expected date.'
            ];
        }

        return [
            'label' => 'Late',
            'class' => 'danger',
            'tooltip' => 'Payment was made after the expected date.'
        ];
    }

}
