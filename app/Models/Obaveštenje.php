<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obaveštenje extends Model
{
    protected $fillable = [
        'korisnik_id',
        'poruka',
        'poslato',
        'način_slanja',
    ];

    protected $casts = [
        'poslato'=>'datetime',
    ];

    public function podsetnik()
    {
        return $this->belongsTo(Podsetnik::class,'korisnik_id');
    }
}
