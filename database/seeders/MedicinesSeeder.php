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
            Medicine::create([
                'ne' => $row[0] ?? null,
                'code' => $row[1] ?? null,
                'name' => $row[2] ?? null,
                'brand' => $row[3] ?? null,
                'form' => $row[4] ?? null,
                'dosage' => $row[5] ?? null,
                'packaging' => $row[6] ?? null,
                'list' => $row[7] ?? null,
                'p1' => $row[8] ?? null,
                'p2' => $row[9] ?? null,
                'obs' => $row[10] ?? null,
                'laboratory' => $row[11] ?? null,
                'type' => $row[12] ?? null,
                'period' => $row[13] ?? null,
            ]);
        }
    }
}
