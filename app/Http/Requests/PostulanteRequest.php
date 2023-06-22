<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostulanteRequest extends FormRequest
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
            'numero' => [
				'required',
				Rule::unique('postulante')->ignore($id)
			],
			'nombre' => 'required',
			'apellidos' => 'required',
			'f_nacimiento' => 'required',
			'email' => [
				'required',
				Rule::unique('users')->ignore($id)
			],
			'password' => 'required',
        ];
    }

	public function messages()
	{
		return [
			'numero.unique' => 'Ya existe una registro con ese documento',
			'numero.required' => 'Campo requerido',
			'nombre.required' => 'Campo requirido',
			'apellidos.required' => 'Campo requirido',
			'f_nacimiento.required' => 'Campo fecha requirido',
			'email.unique' => 'Ya existe una registro con ese correo',
			'email.required' => 'Campo requirido',
			'password.required' => 'Campo requirido'
		];
	}
}
