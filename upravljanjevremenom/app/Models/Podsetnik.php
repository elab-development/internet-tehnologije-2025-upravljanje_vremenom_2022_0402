<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podsetnik extends Model
{
    use HasFactory;
    protected $table='podsetnici'; 
    protected $fillable = [
        'korisnik_id',
        'vreme',
        'aktivan',
    ];

    protected $casts = [
        'vreme'=>'datetime',
        'aktivan'=>'boolean',
    ];

    public function zadatak()
    {
        return $this->belongsTo(Zadatak::class,'korisnik_id');
    }

    public function korisnik()
    {
        return $this->belongsTo(User::class,'korisnik_id');
    }

    public function obavestenja()
    {
        return $this->hasMany(Obavestenje::class,'korisnik_id');
    }
}
