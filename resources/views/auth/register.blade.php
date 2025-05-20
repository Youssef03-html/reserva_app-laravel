@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 col-lg-6">

            <!-- Branding -->
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-3" style="max-width: 100px;">
                <h2 class="fw-bold">Esdeveniments Baix Camp</h2>
                <p class="text-muted">Uneix-te i reserva els teus esdeveniments fàcilment.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <strong>{{ __('Registra\'t') }}</strong>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correu electrònic</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- data de naixement -->
                        <div class="mb-3">
                            <label for="birth_date" class="block font-medium text-sm text-gray-700">
                                {{ __('Data de naixament') }}
                            </label>
                            <input id="birth_date" type="date" class="block mt-1 w-full @error('birth_date') is-invalid @enderror"
                                name="birth_date" value="{{ old('birth_date') }}" required />
                            @error('birth_date')
                                <span class="text-red-600 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contrasenya</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmació de password -->
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirma la contrasenya</label>
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        <!-- Accions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                {{ __('Crear compte') }}
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-link">
                                Ja tens un compte? Inicia sessió
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
