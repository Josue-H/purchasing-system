<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'Pedido';

    public $timestamps = false;

    // Clave primaria de la tabla
    protected $primaryKey = 'idPedido';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'idCliente',
        'nombreEntrega',
        'direccionEntrega',
        'emailEntrega',
        'fechaPedido',
        'estadoPedido',
        'fechaEntrega',
    ];

        // Relación con el modelo Cliente
        public function cliente()
        {
            return $this->belongsTo(Cliente::class, 'idCliente');
        }
    // Relación con los detalles del pedido
    public function detallePedido()
    {
        return $this->hasMany(detallePedido::class, 'idPedido', 'idPedido');
    }

}
