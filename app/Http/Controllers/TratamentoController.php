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
             // Regras de validação
        $rules = [
            'tratamento' => ['required', 'string', 'min:3', 'max:100'],
            'id_caderneta' => ['required', 'exists:cadernetas,id'],
        ];

        $messages = [
            'tratamento.required' => 'O tratamento é obrigatório!',
            'id_caderneta.required' => 'A caderneta é obrigatória!',
            'id_caderneta.exists' => 'A caderneta selecionada não existe!',
        ];

        $request->validate($rules, $messages);

            // Ajusta regras para edição
            if ($request->filled('id')) {
                $TratamentoExistente = Tratamento::find($request->id);
                if (!$TratamentoExistente) {
                    return redirect()->back()->with("ERRO", "Tratamento NÃO ENCONTRADO");
                }
            }

            // Validação
            $request->validate($rules);

            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Tratamento::find($request->id) 
                : new Tratamento();
             
            $valor->tratamento = $request->tratamento;
            $valor->disparasitacao = $request->disparasitacao;
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
