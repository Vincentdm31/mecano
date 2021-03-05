<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    public function pieceList()
    {
        return $this->hasOne(PieceList::class, 'id', 'piece_id');

    }
}
