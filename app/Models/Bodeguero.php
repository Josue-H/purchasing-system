<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bodeguero extends Model
{
    //
    protected $table = 'Bodeguero';

    protected $primaryKey = 'idBodeguero';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'nombreBodeguero',
        'apellidoBodeguero',
        'telefono',
        'email'
    ];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public $incrementing = true;

    protected $keyTipe = 'int';
}
