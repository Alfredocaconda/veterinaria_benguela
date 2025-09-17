<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CadernetaController,
    FuncionarioController,
};
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Rotas públicas (login, registro, etc.)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Rotas protegidas por autenticação
Route::middleware('auth:funcionario')->group(function () {
    Route::get('/', fn() => view('pages.index'))->name('index');
    Route::resource('funcio', FuncionarioController::class);
    Route::get('apagar/{id}/funcio', [FuncionarioController::class, 'apagar'])
        ->name('funcio.apagar');
    Route::resource('cadern', CadernetaController::class);
    Route::get('apagar/{id}/cadern', [CadernetaController::class, 'apagar'])
        ->name('cadern.apagar');
});

       
