<?php

namespace App\Http\Controllers;

use App\Models\funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=Funcionario::orderBy('name','asc')->get();
        return view("pages.funcionario",compact("valor"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Regras de validação
            $rules = [
                'email' => 'required|email|unique:funcionarios,email',
            ];

            // Ajusta regras para edição
            if ($request->filled('id')) {
                $funcionarioExistente = Funcionario::find($request->id);
                if (!$funcionarioExistente) {
                    return redirect()->back()->with("ERRO", "FUNCIONÁRIO NÃO ENCONTRADO");
                }

                $rules['email'] = 'required|email|unique:funcionarios,email,' . $request->id;
                $rules['telefone'] = 'required|digits:9|unique:funcionarios,telefone,' . $request->id;
            }

            // Validação
            $request->validate($rules);
            // Cria ou edita funcionário
            $valor = $request->filled('id') ? Funcionario::find($request->id) : new Funcionario();
            $valor->name=$request->name;
            $valor->cargo=$request->cargo;
            $valor->telefone=$request->telefone;
            $valor->email=$request->email;
            $valor->n_bi=$request->n_bi;
            $valor->password=Hash::make($request->senha);
            $valor->save();

            return redirect()->back()->with("SUCESSO", $request->filled('id') ? "FUNCIONÁRIO ACTUALIZADO COM SUCESSO" : "FUNCIONÁRIO CADASTRADO COM SUCESSO");

        } catch (QueryException $e) {
            return redirect()->back()->with("ERRO", "ERRO AO SALVAR FUNCIONÁRIO. TENTE NOVAMENTE");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $valor=Funcionario::find($id);
        return view("pages.Funcionario",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Funcionario::find($id)->delete();
        return redirect()->back()->with("SUCESSO","FUNCIONARIO ELIMINADO");
    }
}
