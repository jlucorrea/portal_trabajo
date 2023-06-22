@extends('layouts.app')

@section('content')
	<Postulacion :user="{{ json_encode(Auth::user()) }}"/>
@endsection