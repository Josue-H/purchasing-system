<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

  /*   public function getAuthPassword()
    {
        return $this->contraseña;
    }
 */
    protected $table = 'Usuario'; // Especificar la tabla

    // Clave primaria
    protected $primaryKey = 'idUsuario';

    // Si la clave primaria es auto-incremental
    public $incrementing = true;

    // El tipo de la clave primaria
    protected $keyType = 'int';

    // Si la tabla no usa timestamps
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'nombreUsuario',
        'contraseña',
        'idRol',
        'creadoPor',
        'fechaCreacion',
        'codigo_2fa',
        'codigo_2fa_expiracion',
        'codigo_password_reset',
        'codigo_password_reset_expiracion'
    ];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'idUsuario');
    }
    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'idUsuario');
    }
    public function bodeguero()
    {
        return $this->hasOne(Bodeguero::class, 'idUsuario');
    }

    // Método para ocultar la contraseña y códigos en las respuestas JSON
    protected $hidden = [
        'contraseña',
        'codigo_2fa',
        'codigo_2fa_expiracion',
        'codigo_password_reset',
        'codigo_password_reset_expiracion'
    ];

    // Establecer la contraseña usando bcrypt
    public function setContraseñaAttribute($password)
    {
        $this->attributes['contraseña'] = bcrypt($password);
    }

    // Establecer la fecha de creación como el valor actual si no se proporciona
    public function setFechaCreacionAttribute($value)
    {
        $this->attributes['fechaCreacion'] = $value ?? Carbon::now();
    }
}
