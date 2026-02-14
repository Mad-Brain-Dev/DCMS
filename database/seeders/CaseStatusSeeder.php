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
                'table_row_color' => 'table-primary',
                'bg_color' => 'bg-primary',
                'value'       => 'new',
            ],
            [
                'name'        => 'Issued LOD',
                'short_name'  => 'LOD',
                'table_row_color' => 'table-success',
                'bg_color' => 'bg-success',
                'value'       => 'lod',
            ],
            [
                'name'        => 'Verification',
                'short_name'  => 'VER',
                'table_row_color' => 'table-info',
                'bg_color' => 'bg-info',
                'value'       => 'ver',
            ],
            [
                'name'        => 'Field Visit',
                'short_name'  => 'FVS',
                'table_row_color' => 'table-warning',
                'bg_color' => 'bg-warning',
                'value'       => 'fvs',
            ],
            [
                'name'        => 'Negotiating',
                'short_name'  => 'NEG',
                'table_row_color' => 'table-danger',
                'bg_color' => 'bg-danger',
                'value'       => 'neg',
            ],
            [
                'name'        => 'Instalment',
                'short_name'  => 'INS',
                'table_row_color' => 'table-light',
                'bg_color' => 'bg-light',
                'value'       => 'ins',
            ],
            [
                'name'        => 'Further Litigation',
                'short_name'  => 'LIT',
                'table_row_color' => 'table-primary',
                'bg_color' => 'bg-primary',
                'value'       => 'lit',
            ],
            [
                'name'        => 'DB under BKY/DRS',
                'short_name'  => 'BKY',
                'table_row_color' => 'table-primary',
                'bg_color' => 'bg-primary',
                'value'       => 'bky',
            ],
            [
                'name'        => 'Absconded',
                'short_name'  => 'ABS',
                'table_row_color' => 'table-success',
                'bg_color' => 'bg-success',
                'value'       => 'abs',
            ],
            [
                'name'        => 'Closed',
                'short_name'  => 'CLS',
                'table_row_color' => 'table-warning',
                'bg_color' => 'bg-warning',
                'value'       => 'cls',
            ],
            [
                'name'        => 'Fully Paid',
                'short_name'  => 'FPD',
                'table_row_color' => 'table-danger',
                'bg_color' => 'bg-danger',
                'value'       => 'fpd',
            ],
            [
                'name'        => 'Pending',
                'short_name'  => 'PDG',
                'table_row_color' => 'table-light',
                'bg_color' => 'bg-light',
                'value'       => 'fpd',
            ],
        ];

        foreach ($statuses as $status) {
            $status = CaseStatus::create($status);
        }
    }
}
