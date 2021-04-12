<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'brand',
        'license_plate',
        'capacity',
        'model'
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}
