@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 col-lg-6">

            <!-- capçalera mb el logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-3" style="max-width: 100px;">
                <h2 class="fw-bold">Esdeveniments Baix Camp</h2>
                <p class="text-muted">Gestiona i reserva els teus esdeveniments amb facilitat i seguretat.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <strong>{{ __('Inicia Sessió') }}</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Correu electrònic') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Contrasenya') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Recorda\'m') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Entrar') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Has oblidat la contrasenya?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Link al registre -->
            <div class="text-center mt-3">
                <a class="btn btn-link" href="{{ route('register') }}">
                    {{ __("Encara no tens compte? Registra't aquí") }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
