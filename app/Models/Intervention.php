<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    public function operations()
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

    public function pieces()
    {
        return $this->belongsToMany(Piece::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class)->withPivot('id', 'observations');
    }
}
