<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detallePedido extends Model
{
    use HasFactory;
    public $timestamps = false;
    // Nombre de la tabla en la base de datos
    protected $table = 'detallePedido';

    // Clave primaria de la tabla
    protected $primaryKey = 'idDetallePedido';

    // Campos asignables
    protected $fillable = [
        'idPedido',
        'idProducto',
        'cantidad',
        'precioUnitario',
        'descuentoAplicado',
        'precioFinal',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido', 'idPedido');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }
}
