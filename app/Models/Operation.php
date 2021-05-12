<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    public function operationList()
    {
        return $this->hasOne(OperationList::class, 'id', 'operation_id');
    }

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
