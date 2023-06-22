<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'titulo',
        'descripcion',
        'sueldo',
		'estado'
    ];

	public function postulacion()
    {
        return $this->hasMany(Postulacion::class, 'publicacion_id');
    }
}
