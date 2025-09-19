@extends('layouts.base')
@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                   <h4 class="card-title">Lista das Cadernetas de vacinação animal</h4>
                </div>
            </div>
            <div class="head-body">
                <div class="container-fluid">
                    <div class="row">
                        @foreach (App\Models\Caderneta::all() as $item)
                            <div class="col-12 col-md-2 col-lg-2 base-rotas">
                                <a href="#Cadastrar" data-toggle="modal"
                                    data-id="{{ $item->id }}"
                                    data-nome="{{ $item->nome_animal }}">
                                    <div class="rotas">
                                        <h4>{{ $item->nome_animal }}</h4>
                                        --------------
                                        <h4>{{ $item->microchip_n }}</h4>
                                        <h4>{{ $item->cor }}</h4>
                                        <h4>{{ $item->n_registo }}</h4>
                                        <h5>{{ $item->nome_proprietario }}</h5>
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

<!-- Modal -->
<div class="modal fade" id="Cadastrar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Tratamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('trat.store') }}" method="post">
                        @csrf
                        <!-- Escondido para evitar edição manual -->
                        <input type="hidden" name="id_caderneta" id="id_caderneta">

                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="nome_animal"><strong>Animal:</strong></label>
                                <input type="text" id="nome_animal" class="form-control" readonly>
                            </div>

                            <x-input-normal id="tratamento" name="tratamento" type="text" titulo="Tratamento" alert="" />

                            <x-select name="disparasitacao">
                                <option value="1ª doce">1ª doce</option>
                                <option value="2ª doce">2ª doce</option>
                                <option value="vacina">Vacina</option>
                            </x-select>  
                        </div>

                        <div class="modal-footer">
                            <x-botao-form />
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $('#Cadastrar').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);

        var id_caderneta = link.data('id'); 
        var nome_animal = link.data('nome'); 

        console.log("ID:", id_caderneta, "Animal:", nome_animal); // debug

        var modal = $(this);
        modal.find('#id_caderneta').val(id_caderneta);
        modal.find('#nome_animal').val(nome_animal);
        modal.find('.modal-title').text('Cadastrar Tratamento para ' + (nome_animal ?? ''));
    });
</script>
@endsection
