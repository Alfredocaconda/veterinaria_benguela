<?php

namespace App\Http\Controllers;

use App\Models\Vacinacao_raiva;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class VacinacaoRaivaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(){
         $valor=Vacinacao_raiva::orderBy('vacinador','asc')->get();
        return view("pages.vacinacao",compact("valor"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Ajusta regras para edição
            if ($request->filled('id')) {
                $CadernetaExistente = Vacinacao_raiva::find($request->id);
                if (!$CadernetaExistente) {
                    return redirect()->back()->with("ERRO", "VACINAÇÃO DE RAIVA NÃO ENCONTRADO");
                }
            }

            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Vacinacao_raiva::find($request->id) 
                : new Vacinacao_raiva();
             
            $valor->n_lote = $request->n_lote;
            $valor->vacinador = $request->vacinador; // ID do veterinário
            $valor->data = now();
            $valor->id_funcionario = Auth::guard('funcionario')->id();
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "VACINAÇÃO DE RAIVA ACTUALIZADO COM SUCESSO" : "VACINAÇÃO DE RAIVA CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR VACINAÇÃO DE RAIVA. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
   public function show( $id)
    {
        //
        $valor=Vacinacao_raiva::find($id);
        return view("pages.vacinacao",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Vacinacao_raiva::find($id)->delete();
        return redirect()->back()->with("SUCESSO","VACINAÇÃO DE RAIVA ELIMINADO");
    }
}
