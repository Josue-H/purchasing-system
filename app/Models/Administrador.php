<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{

    protected $table = 'Administrador';

    protected $primaryKey = 'idAdministrador';
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'nombreAdministrador',
        'apellidoAdministrador',
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
