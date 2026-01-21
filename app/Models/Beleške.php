<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beleške extends Model
{
    protected $fillable = [
        'korisnik_id',
        'naslov',
        'sadržaj',
    ];

    public function korisnik()
    {
        return $this->belongsTo(User::class,'korisnik_id');
    }

    
}
