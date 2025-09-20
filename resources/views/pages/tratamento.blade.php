@extends('layouts.base') 
@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-sm-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                   <h4 class="card-title">Lista de Tratamento de animal</h4>
                </div>
            </div>
            <div class="head-body">
                <div class="container-fluid">
                    <div class="row">
                       @foreach (App\Models\Caderneta::all() as $item)
                            <div class="col-12 col-md-2 col-lg-2 base-rotas">
                                <a href="javascript:void(0);"
                                onclick="abrirModal('{{ $item->id }}', '{{ $item->nome_animal .' / '. $item->genero_animal  .' / '. $item->especie.' / '. $item->raca.' / '. $item->idade_animal.' Anos' .' / '.$item->cor }}')">
                                    <div class="rotas">
                                        <h4>{{ $item->nome_animal ." / ".$item->genero_animal ." / ". $item->especie." / ". $item->raca." / ". $item->idade_animal." Anos" ." / ".$item->cor }}</h4>
                                        --------------
                                        <h4>{{ $item->n_registo }}</h4>
                                        <h5>{{ $item->nome_proprietario }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
             @if(session('ERRO'))
                    <div class="alert alert-danger">
                        <p>{{session('ERRO')}}</p>
                    </div>
                @endif
                @if(session('SUCESSO'))
                    <div class="alert alert-success">
                        <p>{{session('SUCESSO')}}</p>
                    </div>
                @endif
             <div class="table-responsive">
                    <table id="datatable" class="table data-tables table-striped">
                    <thead>
                        <tr class="ligth">
                            <th>tratamento</th>
                            <th>desparasitacao</th>
                            <th>data</th>
                            <th>id_caderneta</th>
                            <th>id_funcionario</th>
                            <th>Opões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $func)
                            <tr>
                                <td>{{$func->tratamento}}</td>
                                <td>{{$func->desparasitacao}}</td>
                                <td>{{$func->data}}</td>
                                <td>{{$func->id_caderneta}}</td>
                                <td>{{$func->id_funcionario}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{ json_encode($func) }})"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('trat.apagar',$func->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
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
                    <div class="card-body">
               
            </div>

                    <form action="{{ route('trat.store') }}" method="post">
                        @csrf
                        <!-- Escondido para evitar edição manual -->
                        <input type="hidden" name="id" id="id">
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
function abrirModal(id, nome) {
    // Preenche os campos
    document.getElementById('id_caderneta').value = id;
    document.getElementById('nome_animal').value = nome;

    // Abre o modal
    var modal = new bootstrap.Modal(document.getElementById('Cadastrar'));
    modal.show();
}
</script>

@endsection
