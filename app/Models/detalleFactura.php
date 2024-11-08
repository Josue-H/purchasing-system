<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalleFactura extends Model
{
    use HasFactory;

    protected $table = 'DetalleFactura';
    protected $primaryKey = 'idDetalleFactura';
    public $timestamps = false;

    protected $fillable = [
        'idFactura',
        'idProducto',
        'cantidad',
        'precioUnitario',
        'descuentoAplicado',
        'precioFinal',
    ];

    // Relación con Factura
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'idFactura');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}
