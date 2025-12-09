<?php

namespace Database\Seeders;

use App\Models\CaseStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name'        => 'New Case',
                'short_name'  => 'NEW',
                'display_color' => 'table-primary',
                'value'       => 'new',
            ],
            [
                'name'        => 'Issued LOD',
                'short_name'  => 'LOD',
                'display_color' => 'table-success',
                'value'       => 'lod',
            ],
            [
                'name'        => 'Verification',
                'short_name'  => 'VER',
                'display_color' => 'table-info',
                'value'       => 'ver',
            ],
            [
                'name'        => 'Field Visit',
                'short_name'  => 'FVS',
                'display_color' => 'table-warning',
                'value'       => 'fvs',
            ],
            [
                'name'        => 'Negotiating',
                'short_name'  => 'NEG',
                'display_color' => 'table-danger',
                'value'       => 'neg',
            ],
            [
                'name'        => 'Instalment',
                'short_name'  => 'INS',
                'display_color' => 'table-light',
                'value'       => 'ins',
            ],
            [
                'name'        => 'Further Litigation',
                'short_name'  => 'LIT',
                'display_color' => 'table-primary',
                'value'       => 'lit',
            ],
            [
                'name'        => 'DB under BKY/DRS',
                'short_name'  => 'BKY',
                'display_color' => 'table-primary',
                'value'       => 'bky',
            ],
            [
                'name'        => 'Absconded',
                'short_name'  => 'ABS',
                'display_color' => 'table-success',
                'value'       => 'abs',
            ],
            [
                'name'        => 'Closed',
                'short_name'  => 'CLS',
                'display_color' => 'table-warning',
                'value'       => 'cls',
            ],
            [
                'name'        => 'Fully Paid',
                'short_name'  => 'FPD',
                'display_color' => 'table-danger',
                'value'       => 'fpd',
            ],
            [
                'name'        => 'Pending',
                'short_name'  => 'PDG',
                'display_color' => 'table-light',
                'value'       => 'fpd',
            ],
        ];

        foreach ($statuses as $status) {
            $status = CaseStatus::create($status);
        }
    }
}
