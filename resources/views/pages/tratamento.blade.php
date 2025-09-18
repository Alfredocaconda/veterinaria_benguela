@extends('layouts.base')
@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                   <h4 class="card-title">Lista de Rotas</h4>
                   {{-- <a href="#Cadastrar" onclick="limpar()" data-toggle="modal"><i class="fa fa-plus-circle"></i></a> --}}
                </div>
            </div>
            <div class="head-body">
                <div class="container-fluid">
                    <div class="row">
                        @foreach (App\Models\Caderneta::all() as $item)
                            <div class="col-12 col-md-2 col-lg-2 base-rotas">
                                <a href="">
                                    <div class="rotas">
                                        <h4>{{$item->nome_animal}}</h4>
                                            -
                                        <h4>{{$item->microchip_n}}</h4>
                                        <h4>{{$item->cor}}</h4>
                                        <h4>{{ $item->n_registo}}</h4>
                                        <h5>{{$item->nome_proprietario}}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection