<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobCollection;

class JobController extends Controller
{
	
	public function index()
	{
		return view('jobs.index');
	}

	public function columns()
	{
		return [
			'descripcion' => 'Descripción'
		];
	}

	public function records(Request $request)
	{
		$records = Job::where('estado', 1)->where(function ($query) use ($request) {
			if ($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			if(!!$request->titulo)
			{
				$query->where('titulo', 'like', '%'. $request->titulo.'%');
			}
		})->latest();
		return new JobCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

	public function record($id)
	{
		$record = Job::findOrFail($id)->toArray();

		return $record;
	}

	public function store(JobRequest $request)
	{
		$id = $request->input('id');
		$job = Job::firstOrNew(['id' => $id]);
		$job->fill($request->all());
		$job->save();

		return [
			'success' => true,
			'message' => ($id) ? 'Registro Editado' : 'Registro exitoso'
		];
	}

	public function destroy($id)
	{
		$job = Job::find($id);
		$job->update([
			'estado' => 0
		]);

		return response()->json([
			'success' => true,
			'message' => 'Registro Eliminado'
		]);
	}
}
