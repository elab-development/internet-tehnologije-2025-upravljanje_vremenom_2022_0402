<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zadatak extends Model
{
    protected $table='zadaci';
    protected $fillable = [
        'korisnik_id',
        'naslov',
        'opis',
        'uradjeno',
        'rok',
    ];

    protected $casts=[
        'uradjeno'=>'boolean',
        'rok'=>'datetime',
    ];

    public function korisnik()
    {
        return $this->belongsTo(User::class,'korisnik_id');
    }

    public function podsetnik()
    {
        return $this->hasOne(Podsetnik::class,'korisnik_id');
    }

}
