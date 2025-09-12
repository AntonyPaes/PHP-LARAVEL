@extends('layouts.main')

@section('title', 'Criar Jogo')

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Crie o seu Jogo</h1>
        <form action="/events" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Imagem do Jogo:</label>
                <input type="file" id="image" name="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="title">Jogo:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nome do Jogo">
            </div>
            <div class="form-group">
                <label for="date">Data do Jogo:</label>
                <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="title">Estádio:</label>
                <input type="text" class="form-control" id="stadium" name="stadium" placeholder="Nome do Estádio">
            </div>
            <div class="form-group">
                <label for="title">O Jogo é só para sócios ?</label>
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Jogo:</label>
                <textarea name="description" id="description" class="form-control"
                    placeholder="Descrição do Jogo"></textarea>
            </div>
            <div class="form-group">
                <label for="title">Adiocione itens de infraestrutura:</label>
                <div class="form-group">
                        <div class="form-group">
                            <input type="checkbox" name="items[]" id="item1" value="Cadeiras"> <label for="item1">Cadeiras</label>
                            <input type="checkbox" name="items[]" id="item2" value="TV Privativa"> <label for="item2">TV Privativa</label>
                            <input type="checkbox" name="items[]" id="item3" value="Open Drink"> <label for="item3">Open Drink</label>
                            <input type="checkbox" name="items[]" id="item4" value="Estacionamento reservado"> <label
                                for="item4">Estacionamento reservado</label>
                            <input type="checkbox" name="items[]" id="item5" value="Banheiros Exclusivos"> <label for="item5">Banheiros
                                Exclusivos</label>
                            <input type="checkbox" name="items[]" id="item6" value="Serviço de Garçom"> <label for="item6">Serviço de
                                Garçom</label>
                            <input type="checkbox" name="items[]" id="item7" value="Espaço Reservado"> <label for="item7">Espaço
                                Reservado</label>
                            <input type="checkbox" name="items[]" id="item8" value="Encontro com Ídolos do Clube"> <label
                                for="item8">Encontro com Ídolos do Clube</label>
                        </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Criar Jogo">
        </form>
    </div>

@endsection