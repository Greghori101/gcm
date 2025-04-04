<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'ne',
        'code',
        'name',
        'brand',
        'form',
        'dosage',
        'packaging',
        'list',
        'p1',
        'p2',
        'obs',
        'laboratory',
        'country',
        'type',
        'period',
    ];

    public function  prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicine')
            ->using(PrescriptionMedicine::class)
            ->withPivot([
                'is_qsp',
                'quantity',
                'unit',
                'posology',
                'conditions',
            ]);
    }

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }
}
