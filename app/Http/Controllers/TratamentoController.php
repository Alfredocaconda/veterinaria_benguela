<?php

namespace App\Http\Controllers;

use App\Models\Caderneta;
use App\Models\Tratamento;
use Illuminate\Http\Request;

class TratamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view("pages.tratamento");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
