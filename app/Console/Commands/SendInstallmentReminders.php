<?php

namespace App\Console\Commands;

use App\Services\SmsService;
use Illuminate\Console\Command;
use App\Models\Installment;
use Carbon\Carbon;

class SendInstallmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS reminders for upcoming installment payments';

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $reminders = [14, 7, 0];

        foreach ($reminders as $daysBefore) {

            $date = $today->copy()->addDays($daysBefore);

            $installments = Installment::with('case.debtors')
                ->whereDate('next_payment_date', $date)
                ->where('update_type','=','field_visit_update')
                ->get();

            foreach ($installments as $installment) {

                $debtor = $installment->case->debtors->first();

                if (!$debtor || !$debtor->phone) {
                    continue;
                }

                $message = buildInstallmentSms($debtor,$installment);

                $this->smsService->send($debtor->phone, $message);

                \Log::info("SMS sent to {$debtor->phone} for payment on {$installment->next_payment_date->format('Y-m-d')}");
            }
        }

        return 0;
    }
}
