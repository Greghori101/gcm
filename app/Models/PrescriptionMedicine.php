<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PrescriptionMedicine extends Pivot
{
    protected $table = 'prescription_medicine';

    protected $fillable = [
        'is_qsp',
        'quantity',
        'unit',
        'form',
        'dosage',
        'frequency',
        'periodicity',
        'conditions',
        'prescription_id',
        'medicine_id',
    ];

    protected $casts = [
        'conditions' => 'array',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
