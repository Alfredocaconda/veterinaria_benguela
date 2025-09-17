@extends('layouts.base')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title" style="display: flex; justify-content: space-between; width: 100%">
                    <h4 class="card-title">Caderneta de Vacinação de Veterinária Benguela</h4>
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
                            <th>Proprietário</th>
                            <th>Endereço</th>
                            <th>Animal/Genero/Especie/Raça/Idade/Microchip</th>
                            <th>Pelagem</th>
                            <th>Ondulada</th>
                            <th>Cor/Cauda Comprida</th>
                            <th>Nº do Registro</th>
                            <th>Data</th>
                            <th>Opões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valor as $func)
                            <tr>
                                <td>{{$func->nome_proprietario}}</td>
                                <td>{{$func->endereco."/".$func->provincia}}</td>
                               <td>
                                    {{ 
                                        $func->nome_animal . "/" . 
                                        $func->genero_animal . "/" . 
                                        $func->especie . "/" . 
                                        $func->raca . "/" . 
                                        $func->idade_animal ."Anos" . "/" . 
                                        $func->microchip_n
                                    }}
                                </td>

                                <td>{{$func->pelagem_comprida}}</td>
                                <td>{{$func->ondulada}}</td>
                                <td>{{$func->cor."/".$func->cauda_comprida}}</td>
                                <td>{{$func->n_registo}}</td>
                                <td>{{$func->data}}</td>
                                <td>
                                    <a href="#Cadastrar" data-toggle="modal" class="text-primary" onclick="editar({{ json_encode($func) }})"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('cadern.apagar',$func->id)}}" class="text-danger"><i class="fa fa-trash"></i></a>
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
                <h5 class="modal-title">Cadastrar Cadernetas</h5>
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

                    <form action="{{ route('cadern.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <x-input-normal id="nome_proprietario" name="nome_proprietario" type="text" titulo="Nome Completo" alert="" />
                            <x-input-normal id="endereco" name="endereco" type="text" titulo="Bairro/Município" alert="" />
                            <x-input-normal id="provincia" name="provincia" type="text" titulo="Província" alert="" />
                            <x-input-normal id="nome_animal" name="nome_animal" type="text" titulo="Nome do Animal" alert="" />
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="genero_animal">Genero Animal <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <select name="genero_animal" id="genero_animal" class="form-control">
                                        <option value="">Selecionar o Genero</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <x-input-normal id="especie" name="especie" type="text" titulo="Especie Animal" alert="" />
                            <x-input-normal id="raca" name="raca" type="text" titulo="Raça Animal" alert="" />
                            <x-input-normal id="microchip_n" name="microchip_n" type="text" titulo="Microchip" alert="" />
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="idade_animal">Idade do animal <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <input type="text" 
                                           class="form-control" 
                                           name="idade_animal" 
                                           id="idade_animal" 
                                           maxlength="2" 
                                           oninput="formatidade(this)" 
                                           placeholder="XX">
                                    <!-- Mostra quantos caracteres ainda faltam -->
                                    <small id="char_count_idade" class="form-text text-muted">Faltam 2 caracteres</small>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="pelagem_comprida">Pelagem Comprida <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <select name="pelagem_comprida" id="pelagem_comprida" class="form-control">
                                        <option value="">Selecionar a Pelagem</option>
                                        <option value="Curta">Curta</option>
                                        <option value="Comprida">Comprida</option>
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="ondulada">Ondulada <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <select name="ondulada" id="ondulada" class="form-control">
                                        <option value="">Selecionar a Ondulada</option>
                                        <option value="Encarcolada">Encarcolada</option>
                                <option value="Cerdosa">Cerdosa</option>
                                    </select>
                                </div>
                            </div>  
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="cauda_comprida">Cauda <span style="color: red;">*</span></label>
                                <div class="form-input">
                                    <select name="cauda_comprida" id="cauda_comprida" class="form-control">
                                        <option value="">Selecionar a Cauda</option>
                                        <option value="Curta">curta</option>
                                        <option value="Amputada">Amputada</option>
                                    </select>
                                </div>
                            </div>  
                            <x-input-normal id="cor" name="cor" type="text" titulo="COR DO ANIMAL" alert="" />
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
            console.error("Erro: Dados da caderneta não encontrados.");
            return;
        }

        document.getElementById('id').value = valor.id || '';
        document.getElementById('nome_proprietario').value = valor.nome_proprietario || '';
        document.getElementById('endereco').value = valor.endereco || '';
        document.getElementById('provincia').value = valor.provincia || '';
        document.getElementById('nome_animal').value = valor.nome_animal || '';
        document.getElementById('idade_animal').value = valor.idade_animal || '';
        document.getElementById('genero_animal').value = valor.genero_animal || '';
        document.getElementById('cor').value = valor.cor || '';
        document.getElementById('ondulada').value = valor.ondulada || '';
        document.getElementById('pelagem_comprida').value = valor.pelagem_comprida || '';
        document.getElementById('microchip_n').value = valor.microchip_n || '';
        document.getElementById('raca').value = valor.raca || '';
        document.getElementById('cauda_comprida').value = valor.cauda_comprida || '';
        document.getElementById('especie').value = valor.especie || '';


        // Modificar a URL do formulário para apontar para update se for edição
        let form = document.getElementById('formcaderneta');
        if (valor.id) {
            form.action = `/cadern/${valor.id}`;  // Ajuste conforme sua rota de atualização
            form.method = "POST"; // Laravel aceita PUT/PATCH com _method
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
        } else {
            form.action = "{{ route('cadern.store') }}"; // Criar novo
        }
    }

    function limpar() {
        document.getElementById('id').value = "";
        document.getElementById('endereco').value = "";
        document.getElementById('provincia').value = "";
        document.getElementById('nome_animal').value = "";
        document.getElementById('idade_animal').value = "";
        document.getElementById('genero_animal').value = "";
        document.getElementById('cor').value = "";
        document.getElementById('ondulada').value = "";
        document.getElementById('pelagem_comprida').value = "";
        document.getElementById('microchip_n').value = "";
        document.getElementById('raca').value = "";
        document.getElementById('cauda_comprida').value = "";
        document.getElementById('especie').value = "";
    }
            function formatBI(input) {
        let value = input.value.toUpperCase(); // Converte letras para maiúsculas
        let formattedValue = "";
        
        for (let i = 0; i < value.length; i++) {
            if (i < 9) { 
                // Primeiros 9 caracteres devem ser números
                if (/[0-9]/.test(value[i])) {
                    formattedValue += value[i];
                }
            } else if (i < 11) { 
                // Os próximos 2 caracteres devem ser letras
                if (/[A-Z]/.test(value[i])) {
                    formattedValue += value[i];
                }
            } else { 
                // Os últimos 3 caracteres devem ser números
                if (/[0-9]/.test(value[i])) {
                    formattedValue += value[i];
                }
            }
        }

        // Atualiza o valor do input com a formatação correta
        input.value = formattedValue;

        // Atualiza a contagem de caracteres restantes
        let maxLength = 14;
        let currentLength = input.value.length;
        let remaining = maxLength - currentLength;

        let counterElement = document.getElementById("char_count");
        counterElement.textContent = remaining > 0 ? `Faltam ${remaining} caracteres` : "Formato completo!";
    }
    function formatidade(input) {
        let value = input.value.toUpperCase(); // Converte letras para maiúsculas
        let formattedValue = "";
        
        for (let i = 0; i < value.length; i++) {
            if (i < 9) { 
                // Primeiros 9 caracteres devem ser números
                if (/[0-9]/.test(value[i])) {
                    formattedValue += value[i];
                }
            } else if (i < 11) { 
                // Os próximos 2 caracteres devem ser letras
                if (/[A-Z]/.test(value[i])) {
                    formattedValue += value[i];
                }
            } else { 
                // Os últimos 3 caracteres devem ser números
                if (/[0-9]/.test(value[i])) {
                    formattedValue += value[i];
                }
            }
        }

        // Atualiza o valor do input com a formatação correta
        input.value = formattedValue;

        // Atualiza a contagem de caracteres restantes
        let maxLength = 9;
        let currentLength = input.value.length;
        let remaining = maxLength - currentLength;
        let counterElement = document.getElementById("char_count_idade");
        counterElement.textContent = remaining > 0 ? `Faltam ${remaining} caracteres` : "Formato completo!";
    }
</script>
@endsection
