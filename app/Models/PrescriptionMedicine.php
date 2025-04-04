<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PrescriptionMedicine extends Pivot
{
    protected $table = 'prescription_medicine';

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
