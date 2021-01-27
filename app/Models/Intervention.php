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

    public function vehiculeList()
    {
        return $this->hasOne(Vehicule::class, 'id', 'vehicule_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
