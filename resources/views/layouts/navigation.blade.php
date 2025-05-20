<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarContent"
      aria-controls="navbarContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Menú principal -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link @if(request()->routeIs('events.index')) active @endif"
             href="{{ route('events.index') }}">
            Esdeveniments
          </a>
        </li>
        @auth
          @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('admin.events.*')) active @endif"
                 href="{{ route('admin.events.index') }}">
                Administrar esdeveniments
              </a>
            </li>
          @endif
        @endauth
      </ul>

      <!-- Menú d'usuari -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @auth
          <li class="nav-item d-flex align-items-center me-2">
            <span class="navbar-text">
              Benvingut, {{ auth()->user()->name }}
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.edit') }}">Mi Perfil</a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-link nav-link" type="submit">
                Sortir
              </button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Registrar-se</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
