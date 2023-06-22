<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostulacionRequest extends FormRequest
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
        return [
			'descripcion' => 'required',
			'archivo_pdf' => 'required|mimes:pdf',
        ];
    }

	public function messages()
	{
		return [
			'descripcion.required' => 'Campo requerido',
			'archivo_pdf.required' => 'Cv obligatorio para la postulación',
			'archivo_pdf.mimes:pdf' => 'El CV debe ser un archivo de tipo: pdf',
		];
	}
}
