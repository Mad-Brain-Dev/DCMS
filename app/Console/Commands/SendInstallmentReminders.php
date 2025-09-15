<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Installment;
use Carbon\Carbon;
use App\Services\TwilioService;

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

    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        parent::__construct();
        $this->twilio = $twilio;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $reminders = [14, 7, 0]; // days before payment

        foreach ($reminders as $daysBefore) {
            $date = $today->copy()->addDays($daysBefore);

            // Get installments with related case
            $installments = Installment::with('case')
                ->whereDate('next_payment_date', $date)
                ->get();

            foreach ($installments as $installment) {
                $debtorPhone = $installment->case->phone ?? null;

                if ($debtorPhone) {
                    $message = "Reminder: Your installment of {$installment->amount} is due on {$installment->next_payment_date->format('Y-m-d')}.";
                    $this->twilio->sendSms($debtorPhone, $message);

                    \Log::info("SMS sent to {$debtorPhone} for payment on {$installment->next_payment_date->format('Y-m-d')}");
                }
            }
        }

        return 0;
    }
}
