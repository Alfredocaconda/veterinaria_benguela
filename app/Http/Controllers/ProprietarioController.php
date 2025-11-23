<?php

namespace App\Http\Controllers;

use App\Models\Proprietario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProprietarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=Proprietario::orderBy('nome','asc')->get();
        return view("pages.proprietario",compact("valor"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        try {
            // Regras de validação
             //DEFINIR REGRAS DE VALIDAÇÃO
                $rules = [
                'nome' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            ];

            $request->validate($rules, [
                'nome.required' => 'O NOME É OBRIGATÓRIO!',
                'nome.regex' => 'O NOME DEVE CONTER APENAS LETRAS!'
            ]);


            // Ajusta regras para edição
            if ($request->filled('id')) {
                $ProprietarioExistente = Proprietario::find($request->id);
                if (!$ProprietarioExistente) {
                    return redirect()->back()->with("ERRO", "Proprietario NÃO ENCONTRADO");
                }
            }
            // Validação
            $request->validate($rules);
            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Proprietario::find($request->id) 
                : new Proprietario();
            $valor->nome = $request->nome;
            $valor->municipio = $request->municipio;
            $valor->provincia = $request->provincia;
            $valor->bairro = $request->bairro;
            $valor->n_bi = $request->n_bi;
            $valor->telefone = $request->telefone;
            $valor->email = $request->email;
            $valor->id_funcionario = Auth::guard('funcionario')->id();
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "Proprietario DE VACINAÇÃO ACTUALIZADO COM SUCESSO" : "Proprietario DE VACINAÇÃO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR Proprietario DE VACINAÇÃO. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $valor=Proprietario::find($id);
        return view("pages.proprietario",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Proprietario::find($id)->delete();
        return redirect()->back()->with("SUCESSO","Proprietario ELIMINADO");
    }
}
