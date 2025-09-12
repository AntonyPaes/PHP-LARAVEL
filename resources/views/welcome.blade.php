@extends('layouts.main')

@section('title', 'Eventos São Paulo FC')

@section('content')

    <div id="search-container" class="col-md-12">
        <h1>Busque um Jogo</h1>
        <form action="/" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
        </form>
    </div>
    <div id="events-container" class="col-md-12">
        @if ($search)
            <h2>Buscando por: {{ $search }}</h2>
            <p class="subtitle">Resultados da busca</p>
        @else
            <h2>Próximos Jogos</h2>
            <p class="subtitle">Veja os Jogos dos próximos dias</p>
        @endif
        <div id="cards-container" class="row">
            @if(count($events) > 0)
                @foreach ($events as $event)
                    <div class="card col-md-3">
                        <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
                        <div class="card-body">
                            <p class="card-date">
                                {{ date('d/m/Y', strtotime($event->date)) }}
                            </p>
                            <h5 class="card-title">
                                {{ $event->title }}
                            </h5>
                            <p class="card-participants">{{count($event->users)}} Torcedores</p>
                                <a href="/events/{{ $event->id }} " class="btn btn-primary">Saber mais</a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Não foi possível encontrar jogos com: {{ $search }}! <a href="/">Volte a Página Inicial</a></p>
            @endif
        </div>
    </div>
@endsection