<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //

    protected $table = 'Cliente';

    protected $primaryKey = 'idCliente';
    public $timestamps = false;

    protected $fillable = [
        'idCliente', 'idUsuario',  'nombreCliente', 'apellidoCliente', 'direccion', 'telefono', 'esInvitado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public $incrementing = false;

    protected $keyTipe = 'int';
}
