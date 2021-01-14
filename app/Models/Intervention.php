<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    public function operation()
    {
        return $this->hasMany(Operation::class);
    }

    public function piece()
    {
        return $this->hasMany(Piece::class);
    }

    public function vehicule()
    {
        return $this->hasOne(Vehicule::class);
    }
}
