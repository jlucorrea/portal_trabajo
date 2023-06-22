<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

	protected $table = 'postulaciones';

	protected $fillable = [
		'descripcion',
		'postulante_id',
		'publicacion_id'
    ];

	public function postulante()
    {
        return $this->belongsTo(Postulante::class, 'postulante_id');
    }

	public function publicacion()
    {
        return $this->belongsTo(Job::class, 'publicacion_id');
    }


}
