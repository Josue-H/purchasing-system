<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model


{
    protected $table = 'Producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;
    protected $fillable = [
        'nombreProducto',
        'descripcion',
        'precio',
        'stock',
        'imagenUrl'
    ];
}
