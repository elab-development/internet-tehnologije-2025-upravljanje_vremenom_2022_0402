<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beleske extends Model
{
    protected $table='beleska';  
    protected $fillable = [
        'korisnik_id',
        'naslov',
        'sadrzaj',
    ];
    protected $casts = [
        'kreirano' => 'datetime',
    ];

    public function korisnik()
    {
        return $this->belongsTo(User::class,'korisnik_id');
    }

    
}
