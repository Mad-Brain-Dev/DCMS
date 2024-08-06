<?php

namespace App\Console\Commands;

use App\Models\Cases;
use App\Utils\GlobalConstant;
use Illuminate\Console\Command;

class CalculateDailyInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interest:calculate-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store daily compound interest for all accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $accounts = Cases::where('current_status','!=',GlobalConstant::CASE_CLOSED)->get();

            if ($accounts->count() > 0){

                foreach ($accounts as $account) {
                    if($account->interest_type == 'compound'){
                        $interest = calculateDailyCompoundInterest($account->total_amount_owed, $account->debt_interest);

                        // Update the account balance
                        $account->total_amount_owed += $interest;
                        $account->save();
                        \Log::info('Daily compound interest calculated and stored successfully.'.now());
                    }
                    if( $account->interest_type == 'simple' ){

                        $interest = calculateDailySimpleInterest($account->total_amount_owed, $account->debt_interest);

                        // Update the account balance
                        $account->total_amount_owed += $interest;
                        $account->save();
                        \Log::info('Daily simple interest calculated and stored successfully.'.now());

                    }
                    if($account->interest_type == 'no'){
                        \Log::info('No Interest to Calculate.'.now());
                    }

                }

            }else{
                \Log::info('No accounts to calculate.'.now());
            }

        }catch (\Exception $exception){
            \Log::info('Daily compound interest calculated and storing unsuccessfully.'.now());
        }
    }
}
