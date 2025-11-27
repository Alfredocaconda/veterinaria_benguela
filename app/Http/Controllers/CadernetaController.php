<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Caderneta;
use App\Models\Proprietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class CadernetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Carregar caderneta + animal + proprietário do animal + funcionário
    $valor = Caderneta::with([
        'animal.proprietario',
        'funcionario'
    ])->get();

    return view("pages.caderneta", compact("valor"));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        try {
            // Regras de validação
            if ($request->filled('id')) {
                $CadernetaExistente = Caderneta::find($request->id);
                if (!$CadernetaExistente) {
                    return redirect()->back()->with("ERRO", "CADERNETA NÃO ENCONTRADO");
                }
            }
            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Caderneta::find($request->id) 
                : new Caderneta();
            // preencher id_animal
            $valor->id_animal = $request->id_animal;

            // identificar automaticamente o proprietário
            $animal = Animal::find($request->id_animal);
            $valor->id_proprietario = $animal->id_proprietario;

            $valor->n_registo = 'REG-' . time(); // exemplo
            $valor->data = now();
            $valor->id_funcionario = Auth::guard('funcionario')->id();
            $valor->save();
            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "CADERNETA DE VACINAÇÃO ACTUALIZADO COM SUCESSO" : "CADERNETA DE VACINAÇÃO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR CADERNETA DE VACINAÇÃO. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $valor=Caderneta::find($id);
        return view("pages.caderneta",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Caderneta::find($id)->delete();
        return redirect()->back()->with("SUCESSO","CADERNETA DE VACINAÇÃO ELIMINADO");
    }
}
