<?php

namespace App\Http\Controllers;

use App\Models\Caderneta;
use Illuminate\Http\Request;

class CadernetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=Caderneta::orderBy('nome_proprietario','asc')->get();
        return view("pages.caderneta",compact("valor"));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        try {
            // Regras de validação
             //DEFINIR REGRAS DE VALIDAÇÃO
                $rules = [
                'nome_proprietario' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                'nome_animal' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                'endereco' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                'provincia' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
                
            ];

            $request->validate($rules, [
                'nome_proprietario.required' => 'O NOME É OBRIGATÓRIO!',
                'nome_proprietario.regex' => 'O NOME DEVE CONTER APENAS LETRAS!',
                'nome_animal.required' => 'O NOME É OBRIGATÓRIO!',
                'nome_animal.regex' => 'O NOME DEVE CONTER APENAS LETRAS!',
               
            ]);


            // Ajusta regras para edição
            if ($request->filled('id')) {
                $CadernetaExistente = Caderneta::find($request->id);
                if (!$CadernetaExistente) {
                    return redirect()->back()->with("ERRO", "FUNCIONÁRIO NÃO ENCONTRADO");
                }

                $rules['email'] = 'required|email|unique:Cadernetas,email,' . $request->id;
                $rules['telefone'] = 'required|digits:9|unique:Cadernetas,telefone,' . $request->id;
            }

            // Validação
            $request->validate($rules);

            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Caderneta::find($request->id) 
                : new Caderneta();
                
            $valor->nome_proprietario = $request->nome_proprietario;
            $valor->endereco = $request->endereco;
            $valor->provincia = $request->provincia;
            $valor->nome_animal = $request->nome_animal;
            $valor->genero_animal = $request->genero_animal;
            $valor->especie = $request->especie;
            $valor->raca = $request->raca;
            $valor->idade_animal = $request->idade_animal;
            $valor->microchip_n = $request->microchip_n;
            $valor->pelagem_comprida = $request->pelagem_comprida;
            $valor->ondulada = $request->ondulada;
            $valor->cor = $request->cor;
            $valor->cauda_comprida = $request->cauda_comprida;
            $valor->n_registo = $request->n_registo;
            $valor->data = now();
            $valor->id_funcionario = Auth::guard('funcionario')->user()->id;
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "FUNCIONÁRIO ACTUALIZADO COM SUCESSO" : "FUNCIONÁRIO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR FUNCIONÁRIO. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Caderneta $caderneta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caderneta $caderneta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caderneta $caderneta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caderneta $caderneta)
    {
        //
    }
}
