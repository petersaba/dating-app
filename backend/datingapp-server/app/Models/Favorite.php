<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    function Favoriter(){
        return $this->belongsTo(User::class, 'favoriter_id');
    }

    function Favorited(){
        return $this->belongsTo(User::class, 'favorited_id');
    }
}
