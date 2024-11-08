<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	// public function toArray(Request $request)
	// {
	// 	return $this->collection->transform(function($row, $key) {
	//         return [
	//             'id' => $row->id,
	//             'email' => $row->email,
	//             'name' => $row->name,
	//             'api_token' => $row->api_token,
	//             'admin' => $row->admin,
	//             'establishment_description' => optional($row->establishment)->description,
	//         ];
	//     });
	// }

	public function toArray(Request $request): array
	{
		return $this->collection->map(function ($row) {
			return [
				'id' => $row->id,
				'email' => $row->email,
				'name' => $row->name
			];
		})->toArray();
	}
}
