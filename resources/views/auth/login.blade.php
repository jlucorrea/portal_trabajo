@extends('layouts.app')

@section('content')
<main class="form-signin w-100 m-auto mt-5">
	<form autocomplete="off" method="POST" action="{{ route('login') }}">
		@csrf
		<img class="mb-4" src="https://cdn-icons-png.flaticon.com/512/8037/8037350.png" alt="" height="57">
		<h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
		<div class="form-floating">
			<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
			<label for="email">Email</label>
			@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		<div class="form-floating">
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
			<label for="password">Contraseña</label>
			@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
		<button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>
		<p class="mt-5 mb-3 text-body-secondary">© <b>JLucorrea</b> 2023</p>
	</form>
</main>
@endsection

<style>
html,
body {
	height: 100%;
}
.form-signin {
	max-width: 330px;
	padding: 1rem;
}
.form-signin .form-floating:focus-within {
	z-index: 2;
}
.form-signin input[type="email"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>
