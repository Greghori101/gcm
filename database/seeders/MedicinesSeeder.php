<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $filePath = database_path('data/medicines.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        foreach ($rows as $row) {
            if ($row[1]===NULL && $row[2]===NULL && $row[3]===NULL) {
                break;
            }
            Medicine::create([
                'ne' => $row[1] ?? null,
                'code' => $row[2] ?? null,
                'name' => $row[3] ?? null,
                'brand' => $row[4] ?? null,
                'form' => $row[5] ?? null,
                'dosage' => $row[6] ?? null,
                'packaging' => $row[7] ?? null,
                'list' => $row[8] ?? null,
                'p1' => $row[9] ?? null,
                'p2' => $row[10] ?? null,
                'obs' => $row[11] ?? null,
                'laboratory' => $row[12] ?? null,
                'country' => $row[13] ?? null,
                'type' => $row[16] ?? null,
                'period' => $row[18] ?? null,
            ]);
        }
    }
}
