@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Meus jogos</h1>
    </div>
    <div class="col-md-10 offset-md-1 dahsboard-events-container">
        @if (count($events) > 0)
            @else
            <p>Você ainda não tem um jogo, <a href="/events/create">Criar Jogo</a>
        </p>
        @endif
    </div>

@endsection
