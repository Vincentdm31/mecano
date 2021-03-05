<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceList extends Model
{
    use HasFactory;

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }
}
