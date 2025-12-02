<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Plank\Mediable\Facades\MediaUploader;
use PDF;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function index()
    {
        //
        $valor=Animal::orderBy('nome','asc')->get();
        return view("pages.Animal",compact("valor"));
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
            ]);
            // Ajusta regras para edição
            if ($request->filled('id')) {
                $AnimalExistente = Animal::find($request->id);
                if (!$AnimalExistente) {
                    return redirect()->back()->with("ERRO", "ANIMAL NÃO ENCONTRADO");
                }
            }

            // Validação
            $request->validate($rules);

            // Cria ou edita funcionário
            $valor = $request->filled('id') 
                ? Animal::find($request->id) 
                : new Animal();
             
            $valor->nome = $request->nome;
            $valor->genero = $request->genero;
            $valor->especie = $request->especie;
            $valor->raca = $request->raca;
            $valor->idade = $request->idade;
            $valor->pelagem_comprida = $request->pelagem_comprida;
            $valor->ondulada = $request->ondulada;
            $valor->cor = $request->cor;
            $valor->cauda_comprida = $request->cauda_comprida;
            $valor->id_proprietario = $request->responsavel;
            $valor->id_funcionario = Auth::guard('funcionario')->id();
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "ANIMAL ACTUALIZADO COM SUCESSO" : "Animal DE VACINAÇÃO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR ANIMAL. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $valor=Animal::find($id);
        return view("pages.Animal",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Animal::find($id)->delete();
        return redirect()->back()->with("SUCESSO","ANIMAL ELIMINADO");
    }
    //Gerar o comprovativo
    public function gerarPdf($id)
    {
        $animal = Animal::with('proprietario')->findOrFail($id);
        $pdf = Pdf::loadView('pages.pdfs.pdf_animal', compact('animal'));
        return $pdf->stream("animal_{$animal->nome}.pdf");
    }
}