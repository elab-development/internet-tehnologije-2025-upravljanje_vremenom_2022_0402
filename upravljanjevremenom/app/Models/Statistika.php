<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistika extends Model
{
    protected $table='statistike'; 
    protected $fillable = [
        'korisnik_id',
        'ukupan_broj_zadataka',
        'broj_odradjenih_zadataka',
        'procenat_uspesnosti',
    ];

    protected $casts = [
        'ukupan_broj_zadataka'=>'integer',
        'broj_odrađenih_zadataka'=>'integer',
        'procenat_uspešnosti'=>'float',
    ];

    public function korisnik()
    {
        return $this->belongsTo(User::class,'korisnik_id');
    }
}
