<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    //public $timestamps = false;
    
    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }


}
