@extends('layouts.main')

@section('title', 'Editando: ' . $event->title);

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Editando: {{ $event->title }}</h1>
        <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Adicione um campo oculto com o ID do evento --}}
            <input type="hidden" name="id" value="{{ $event->id }}">

            <div class="form-group">
                <label for="image">Imagem do Jogo:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                <img src="/img/events/{{ $event->image }}" alt="{{$event->title}}" class="img-preview">
            </div>
            <div class="form-group">
                <label for="title">Jogo:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nome do Jogo" value="{{ $event->title }}">
            </div>
            <div class="form-group">
                <label for="date">Data do Jogo:</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}"> 
            </div>
            <div class="form-group">
                <label for="stadium">Estádio:</label>
                <input type="text" class="form-control" id="stadium" name="stadium" placeholder="Nome do Estádio" value="{{ $event->stadium }}">
            </div>
            <div class="form-group">
                <label for="private">O Jogo é só para sócios ?</label>
                <select name="private" id="private" class="form-control">
                    <option value="0">Não</option>
                    <option value="1" {{ $event->private == 1 ? "selected='selected'" : "" }}> Sim</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descrição do Jogo:</label>
                <textarea name="description" id="description" class="form-control"
                          placeholder="Descrição do Jogo">{{ $event->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="items">Adiocione itens de infraestrutura:</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" id="item1" value="Cadeiras" {{ in_array('Cadeiras', $event->items) ? 'checked' : '' }}> <label for="item1">Cadeiras</label>
                    <input type="checkbox" name="items[]" id="item2" value="TV Privativa" {{ in_array('TV Privativa', $event->items) ? 'checked' : '' }}> <label for="item2">TV Privativa</label>
                    <input type="checkbox" name="items[]" id="item3" value="Open Drink" {{ in_array('Open Drink', $event->items) ? 'checked' : '' }}> <label for="item3">Open Drink</label>
                    <input type="checkbox" name="items[]" id="item4" value="Estacionamento reservado" {{ in_array('Estacionamento reservado', $event->items) ? 'checked' : '' }}> <label for="item4">Estacionamento reservado</label>
                    <input type="checkbox" name="items[]" id="item5" value="Banheiros Exclusivos" {{ in_array('Banheiros Exclusivos', $event->items) ? 'checked' : '' }}> <label for="item5">Banheiros Exclusivos</label>
                    <input type="checkbox" name="items[]" id="item6" value="Serviço de Garçom" {{ in_array('Serviço de Garçom', $event->items) ? 'checked' : '' }}> <label for="item6">Serviço de Garçom</label>
                    <input type="checkbox" name="items[]" id="item7" value="Espaço Reservado" {{ in_array('Espaço Reservado', $event->items) ? 'checked' : '' }}> <label for="item7">Espaço Reservado</label>
                    <input type="checkbox" name="items[]" id="item8" value="Encontro com Ídolos do Clube" {{ in_array('Encontro com Ídolos do Clube', $event->items) ? 'checked' : '' }}> <label for="item8">Encontro com Ídolos do Clube</label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Salvar Alterações">
        </form>
    </div>

@endsection