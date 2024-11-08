<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'Factura';
    protected $primaryKey = 'idFactura';
    public $timestamps = false;

    protected $fillable = [
        'idCliente',
        'idUsuario',
        'fechaFactura',
        'totalFactura',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    // Relación con Usuario (quien generó la factura)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function detalleFactura()
    {
        return $this->hasMany(DetalleFactura::class, 'idFactura', 'idFactura');
    }
}
