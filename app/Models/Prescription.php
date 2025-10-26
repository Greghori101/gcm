<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'nb',
        'date',
        'purpose',
        'diagnostic',
        'patient_id',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function  patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine')
            ->withPivot([
                'is_qsp',
                'quantity',
                'qte',
                'unit',
                'form',
                'dosage',
                'frequency',
                'periodicity',
                'conditions',
            ]);
    }


    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }
}
