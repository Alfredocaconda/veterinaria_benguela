<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Ficha do Animal</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 14px;
        }
        .cabecalho {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .titulo {
            font-size: 18px;
            font-weight: bold;
        }
        .subtitulo {
            font-size: 14px;
        }
        .conteudo {
            margin-top: 30px;
        }
        .info {
            margin-bottom: 15px;
        }
        .rodape {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="cabecalho">
        <!--<img src="{{ public_path('imagem/logotipo.jpeg') }}" class="logo" alt="Logotipo">-->
        <div class="titulo">VETERINÁRIA PÚBLICA DE BENGUELA</div>
        <div class="subtitulo">Departamento de Registo dos Animais</div>
    </div>

    <div class="conteudo">
        <h2>Ficha</h2>
        <h2>Dados do Responsavel</h2>
        <div class="info"><strong>Nome:</strong> {{ $animal->proprietario->nome }}</div>
        <div class="info"><strong>Nº do Bilhete:</strong> {{ $animal->proprietario->n_bi }}</div>
        <div class="info"><strong>Endereço:</strong> {{$animal->proprietario->bairro." / ".$animal->proprietario->municipio." / ".$animal->proprietario->provincia}}</div>
        <div class="info"><strong>Telefone:</strong> {{ $animal->proprietario->telefone }}</div>
        <h2>Dados do Animal</h2>
        <div class="info"><strong>Nome do Animal:</strong> {{ $animal->nome }}</div>
        <div class="info"><strong>Gênero:</strong> {{ $animal->genero }}</div>
        <div class="info"><strong>Idade:</strong> {{ $animal->idade." Anos" }}</div>
        <div class="info"><strong>Raça:</strong> {{ $animal->raca}}</div>
        <div class="info"><strong>Pelagem:</strong> {{ $animal->pelagem_comprida}}</div>
        <div class="info"><strong>Cor:</strong> {{ $animal->cor }}</div>
        <div class="info"><strong>Cauda:</strong> {{ $animal->cauda_comprida }}</div>
    </div>
    <div class="rodape">
    VATERINÁRIA PÚBLICA DE BENGUELA | Rua 123, Benguela | Tel: +244 900 000 000
    </div>
</body>
</html>
