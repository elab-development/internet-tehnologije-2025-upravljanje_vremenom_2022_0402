<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obavestenje extends Model
{
    protected $table='obavestenja'; 
    protected $fillable = [
        'korisnik_id',
        'poruka',
        'poslato',
        'nacin_slanja',
    ];

    protected $casts = [
        'poslato'=>'datetime',
    ];

    public function podsetnik()
    {
        return $this->belongsTo(Podsetnik::class,'korisnik_id');
    }
}
