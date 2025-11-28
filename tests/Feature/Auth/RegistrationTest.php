<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'birth_date' => '2000-01-01',        // camp obligatori del teu formulari
        'password' => 'password123',         // min:8 a la validació
        'password_confirmation' => 'password123',
    ]);

    // El controller fa Auth::login($user) i retorna redirect al dashboard
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    // Opcional: comprovar que l'usuari s'ha creat a la BD
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name'  => 'Test User',
    ]);
});

