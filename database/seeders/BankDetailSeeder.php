<?php

namespace Database\Seeders;

use App\Models\BankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'tenant_id'        => 1,
                'account_name'         => 'Secure Collection Pte Ltd',
                'bank_name'         => 'CIMB Bank Berhad, Singapore',
                'account_number'             => '2001038643',
                'bank_code' => '7986',
                'branch_code'          => '001',
                'bank_address'         => '30 Raffles Place, #04-01, Singapore 048622',
                'swift_code'            => 'CIBBSGSG',
                'payment_methods'    => 'TT, Cheque, or PayNow (87428158)',
                'payment_terms'             => 'Immediate',
            ]
        ];

        foreach ($banks as $bank) {
            $bank = BankDetail::create($bank);
        }
    }
}
