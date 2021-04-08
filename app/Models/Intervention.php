<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = ['qte'];

    public function vehiculeList()
    {
        return $this->hasOne(Vehicule::class, 'id', 'vehicule_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->distinct();
    }

    public function operations()
    {
        return $this->hasMany(Operation::class)->orderBy('id', 'DESC');
    }
}
