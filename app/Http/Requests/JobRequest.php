<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
		$id = $this->input('id');
        return [
            'titulo' => [
				'required',
				Rule::unique('jobs')->ignore($id)
			],
			'descripcion' => 'required',
			'sueldo' => 'required'
        ];
    }

	public function messages()
	{
		return [
			'titulo.unique' => 'Ya existe una registro con ese nombre',
			'titulo.required' => 'Campo requerido',
			'descripcion.required' => 'Campo requirido',
			'sueldo.required' => 'Campo requirido',
		];
	}
}
