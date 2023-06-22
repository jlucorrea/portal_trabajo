@include('layouts.icon')
<header>
    <div class="px-3 py-2 text-bg-dark border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/"
                    class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
						<li>
							<a href="{{ url('/') }}" class="nav-link text-white">
								<svg class="bi d-block mx-auto mb-1" width="24" height="24">
									<use xlink:href="#home"></use>
								</svg>
								Publicaciones
							</a>
						</li>
					@guest
						<li>
							@if (Route::has('login'))
								<a href="{{ route('login') }}" class="nav-link text-white">
									<svg class="bi d-block mx-auto mb-1" width="24" height="24">
										<use xlink:href="#people-circle"></use>
									</svg>
									Iniciar Sesión
								</a>
							@endif
						</li>
						<li>
							@if (Route::has('register'))
								<a href="{{ route('register') }}" class="nav-link text-white">
									<svg class="bi d-block mx-auto mb-1" width="24" height="24">
										<use xlink:href="#people-circle"></use>
									</svg>
									Registrarse
								</a>
							@endif
						</li>
					@else
						<li>
							<a href="{{ route('home') }}" class="nav-link text-white">
								<svg class="bi d-block mx-auto mb-1" width="24" height="24">
									<use xlink:href="#speedometer2"></use>
								</svg>
								Inicio
							</a>
						</li>
						<li>
							<a href="{{ route('jobs') }}" class="nav-link text-white">
								<svg class="bi d-block mx-auto mb-1" width="24" height="24">
									<use xlink:href="#table"></use>
								</svg>
								Trabajos
							</a>
						</li>
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
								data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }}
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
									Salir
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
						</li>
					@endguest
                </ul>
            </div>
        </div>
    </div>
</header>