<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

//DB name, last_payment_date, last_payment_amount, next_payment_date,next_payment_amount, balance
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'last_payment_date'=>$this->installments->last()?->date_of_payment,
            'last_payment_amount'=>$this->installments->last()?->amount_paid,
            'next_payment_date'=>$this->installments->last()?->next_payment_date,
            'next_payment_amount'=>$this->installments->last()?->next_payment_amount,
            'balance'=>$this->total_amount_balance,
        ];
    }
}
