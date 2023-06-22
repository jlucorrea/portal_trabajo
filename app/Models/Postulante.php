<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    use HasFactory;

	protected $table = 'postulante';
	
	protected $fillable = [
		'tipo_doc',
		'numero',
		'nombre',
		'apellidos',
		'f_nacimiento'
    ];

	public function user()
    {
		return $this->hasMany(User::class, 'postulante_id');
    }
}
