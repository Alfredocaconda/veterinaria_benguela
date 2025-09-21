<?php

namespace App\Http\Controllers;

use App\Models\Tratamento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class TratamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
         $valor=Tratamento::orderBy('tratamento','asc')->get();
        return view("pages.tratamento",compact("valor"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
             //DEFINIR REGRAS DE VALIDAÇÃO
                $rules = [
                'tratamento' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                
            ];

            $request->validate($rules, [
                'tratamento.required' => 'O NOME É OBRIGATÓRIO!',
                'desparasitacao.required' => 'O NOME É OBRIGATÓRIO!',
                'tratamento.regex' => 'O NOME DEVE CONTER APENAS LETRAS!',
                
            ]);
            // Ajusta regras para edição
            if ($request->filled('id')) {
                $CadernetaExistente = Tratamento::find($request->id);
                if (!$CadernetaExistente) {
                    return redirect()->back()->with("ERRO", "TRATAMENTO NÃO ENCONTRADO");
                }
            }

            // Validação
            $request->validate($rules);

            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Tratamento::find($request->id) 
                : new Tratamento();
             
            $valor->tratamento = $request->tratamento;
            $valor->desparasitacao = $request->desparasitacao;
            $valor->id_caderneta = $request->id_caderneta;
            $valor->data = now();
            $valor->id_funcionario = Auth::guard('funcionario')->id();
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "TRATAMENTO ACTUALIZADO COM SUCESSO" : "TRATAMENTO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR TRATAMENTO. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
   public function show( $id)
    {
        //
        $valor=Tratamento::find($id);
        return view("pages.tratamento",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Tratamento::find($id)->delete();
        return redirect()->back()->with("SUCESSO","TRATAMENTO ELIMINADO");
    }
}
