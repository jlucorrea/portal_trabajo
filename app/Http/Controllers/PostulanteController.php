<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Postulante;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PostulanteRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PostulacionRequest;

class PostulanteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
	}

	public function register(PostulanteRequest $request)
	{
		try {
			DB::beginTransaction();

			$postulante = new Postulante();
			$postulante->fill($request->all());
			$postulante->save();

			User::create([
				'name' => $request->nombre,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'postulante_id' => $postulante->id
			]);

			DB::commit();

			return response([
				'success' => true,
				'message' => 'Registrado con éxito, !Porfavor para poder postular a los puestos de trabajo inicie sesión con sus credenciales',
			], Response::HTTP_OK);

		} catch (\Exception $e) {
			DB::rollback();

			return response([
				'success' => false,
				'message' => 'Ocurrió un error durante la transacción',
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	public function postulaciones(PostulacionRequest $request)
	{
		$archivoPdf = $request->file('archivo_pdf');
        $archivoPdfPath = $archivoPdf->store('pdfs');

		$postulacion = new Postulacion();
		$postulacion->fill($request->all());
		$postulacion->archivo_pdf = $archivoPdfPath;
		$postulacion->save();

		return [
			'success' => true,
			'message' => 'Postulación registrada con éxito'
		];
	}

	public function postulado($id)
	{
		$record = Postulacion::where('postulante_id', $id)->get();
		return $record;
	}

	public function destroy(string $id)
	{
		//
	}
}
