<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AnimalController,
    CadernetaController,
    FuncionarioController,
    ProprietarioController,
    TratamentoController,
    VacinacaoRaivaController,
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
    Route::get('/', function () {
        return view('pages.index');
    })->name('index');
    Route::resource('funcio', FuncionarioController::class);
    Route::get('apagar/{id}/funcio', [FuncionarioController::class, 'apagar'])
        ->name('funcio.apagar');
    Route::resource('prop', ProprietarioController::class);
    Route::get('apagar/{id}/prop', [ProprietarioController::class, 'apagar'])
        ->name('prop.apagar');
    Route::resource('cadern', CadernetaController::class);
    Route::get('apagar/{id}/cadern', [CadernetaController::class, 'apagar'])
        ->name('cadern.apagar');
    Route::resource('trat', TratamentoController::class);
    Route::get('apagar/{id}/trat', [TratamentoController::class, 'apagar'])
        ->name('trat.apagar');
    Route::resource('vaci', VacinacaoRaivaController::class);
    Route::get('apagar/{id}/vaci', [VacinacaoRaivaController::class, 'apagar'])
        ->name('vaci.apagar');
    Route::resource('animal', AnimalController::class);
    Route::get('apagar/{id}/animal', [AnimalController::class, 'apagar'])
        ->name('animal.apagar');
    Route::get('/animal/pdf/{id}', [AnimalController::class, 'gerarPdf'])->name('animal.pdf');
    Route::get('/caderneta/pdf/{id}', [CadernetaController::class, 'gerarPdf'])->name('caderneta.pdf');
});

       
