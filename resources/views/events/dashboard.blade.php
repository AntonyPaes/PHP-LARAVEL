@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Meus jogos</h1>
    </div>
    <div class="col-md-10 offset-md-1 dahsboard-events-container">
        @if (count($events) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Torcedores</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td scope="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/events/{{ $event->id }}"> {{ $event->title }}</a></td>
                            <td>{{ count($event->users) }}</td>
                            <td class="actions-btn-container">
                                <a href="/events/edit/{{ $event->id }}" class="btn btn-info edit-btn"><ion-icon
                                        name="create-outline"></ion-icon>Editar</a>
                                <form action="/events/{{ $event->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn"><ion-icon
                                            name="trash-outline"></ion-icon>Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não tem um jogo, <a href="/events/create">Criar Jogo</a></p>
        @endif
    </div>
    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Jogos que esta participando</h1>
    </div>
    <div class="col-md-10 offset-md-1 dahsboard-events-container">
        @if (count($jogosAsParticipants) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Torcedores</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jogosAsParticipants as $event)
                        <tr>
                            <td scope="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/events/leave/{{ $event->id }}"> {{ $event->title }}</a></td>
                            <td>{{ count($event->users) }}</td>
                            <td class="actions-btn-container">
                                <form action="/events/leave/{{ $event->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn"><ion-icon
                                            name="trash-outline"></ion-icon>Sair do jogo</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p>Você ainda não esta participando de nenhum jogo, <a href="/">Veja os jogos disponiveis</a></p>
        @endif
    </div>

@endsection