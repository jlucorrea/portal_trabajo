<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

	public function toArray(Request $request): array
	{
		return $this->collection->map(function ($row) {
			return [
				'id' => $row->id,
                'titulo' => $row->titulo,
				'descripcion' => $row->descripcion,
				'sueldo' => $row->sueldo,
				'fecha' => optional($row->created_at)->format('Y-m-d'),
				'postulacion' => $row->postulacion
			];
		})->toArray();
	}
}
