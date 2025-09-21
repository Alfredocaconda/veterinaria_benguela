@extends('layouts.base')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Vacinação Contra a Raiva</h4>
                    <a href="#Cadastrar" data-toggle="modal" style="font-size: 20pt"><i class="fa fa-plus-circle"></i></a>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table data-tables table-striped">
                    <thead>
                        <tr class="ligth">
                            <th>Vacinador</th>
                            <th>Número de Lote</th>
                            <th>Data</th>
                            <th>Funcionario</th>
                            <th>Opões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $func)
                            <tr>
                                <td>{{$func->vacinadorFuncionario->name ?? 'N/A' }}</td>
                                <td>{{$func->n_lote}}</td>
                                <td>{{$func->data}}</td>
                                <td>{{$func->Funcionario->name}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{ json_encode($func) }})"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('vaci.apagar',$func->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
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
</div>

<!-- Modal -->
<div class="modal fade" id="Cadastrar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Vacinação Contra a Raiva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    
                    <!-- EXIBIR ERROS DE VALIDAÇÃO AQUI -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('vaci.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <!-- Escondido para evitar edição manual -->
                        <div class="row">
                            <x-input-normal id="n_lote" name="n_lote" type="text" titulo="Nº de Lotes" alert="" />
                             <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="vacinador">Selecionar a Vacinador <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <select class="form-control" name="vacinador" id="vacinador">
                                        @foreach (App\Models\Funcionario::where('cargo', 'veterinario')->orderBy('name','ASC')->get() as $funcio)
                                            <option value="{{ $funcio->id }}">{{ $funcio->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
function editar(valor) {
        if (!valor) {
            console.error("Erro: Dados do vaciamento não encontrados.");
            return;
        }

        document.getElementById('id').value = valor.id || '';
        document.getElementById('n_lote').value = valor.n_lote || '';
        document.getElementById('vacinador').value = valor.vacinador || '';
        // Modificar a URL do formulário para apontar para update se for edição
        let form = document.getElementById('formVacinacao');
        if (valor.id) {
            form.action = `/vaci/${valor.id}`;  // Ajuste conforme sua rota de atualização
            form.method = "POST"; // Laravel aceita PUT/PATCH com _method
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
        } else {
            form.action = "{{ route('vaci.store') }}"; // Criar novo
        }
    }

    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('n_lote').value = "";
        document.getElementById('vacinador').value = "";
    }
 
</script>

@endsection