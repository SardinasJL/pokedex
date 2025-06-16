<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pokemon;
use App\Models\Tipo;


Auth::routes(["register" => false, "reset" => false]);

Route::get("login/google/redirect", function () {
    return Socialite::driver("google")->redirect();
})->name("login.google.redirect");

Route::get("login/google/callback", function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::updateOrCreate([
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'password' => bcrypt(Str::random(16)),//el password creado por la autenticación de Google no sirve para nada xd
        'token' => $googleUser->token,
    ]);
    Auth::login($user);
    return redirect()->route("pokemons.index");
})->name("login.google.callback");

Route::group(["middleware" => "auth"], function () {
    Route::get('/', function () {
        $cantidadPokemons = Pokemon::count();
        $cantidadTipos = Tipo::count();
        return view("dashboard", compact("cantidadPokemons", "cantidadTipos"));
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource("pokemons", "App\Http\Controllers\PokemonController");
    Route::resource("tipos", "App\Http\Controllers\TipoController");
});
