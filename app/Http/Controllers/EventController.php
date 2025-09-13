<?php

namespace App\Http\Controllers;

use App\Models\Jogo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller para gerenciar a lógica de Jogos (Eventos).
 * NOTA: Considerar renomear para JogoController para maior clareza.
 */
class EventController extends Controller
{
    /**
     * Exibe a página inicial com a lista de todos os jogos ou os resultados de uma busca.
     */
    public function index(): View
    {
        $search = request('search');

        $query = Jogo::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return view('welcome', [
            'events' => $query->get(),
            'search' => $search
        ]);
    }

    /**
     * Exibe o formulário para criar um novo jogo.
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Salva um novo jogo no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $jogo = new Jogo;

        $jogo->title = $request->title;
        $jogo->date = $request->date;
        $jogo->stadium = $request->stadium;
        $jogo->private = $request->private;
        $jogo->description = $request->description;
        $jogo->items = $request->items;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $jogo->image = $imageName;
        }

        $jogo->user_id = auth()->id();
        $jogo->save();

        return redirect('/')->with('msg', 'Jogo criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um jogo específico.
     *
     * @param string $id O ID do jogo.
     */
    public function show(string $id): View
    {
        $event = Jogo::findOrFail($id);

        $hasUserJoined = false;
        if (auth()->check()) {
            // Maneira eficiente de verificar se o usuário participa, sem carregar todos os eventos.
            $hasUserJoined = auth()->user()->jogosParticipants()->where('jogo_id', $id)->exists();
        }

        return view('events.show', [
            'event' => $event,
            'eventOwner' => $event->user, // Acessa a relação diretamente, mais eficiente.
            'hasUserJoined' => $hasUserJoined
        ]);
    }

    /**
     * Exibe o dashboard do usuário com seus jogos criados e os que participa.
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        return view('events.dashboard', [
            'events' => $user->jogos,
            'jogosAsParticipants' => $user->jogosParticipants
        ]);
    }

    /**
     * Exclui um jogo do banco de dados.
     */
    public function destroy(string $id): RedirectResponse
    {
        Jogo::findOrFail($id)->delete();
        return redirect('/dashboard')->with('msg', 'Jogo excluído com sucesso!');
    }

    /**
     * Exibe o formulário para editar um jogo existente.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $user = auth()->user();
        $event = Jogo::findOrFail($id);

        // Lógica de autorização: Apenas o dono do jogo pode editar.
        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    /**
     * Atualiza os dados de um jogo no banco de dados.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }

        // Garante que 'items' seja um array para evitar erros na conversão para JSON.
        $data['items'] = $request->items ?? [];

        Jogo::findOrFail($id)->update($data);

        return redirect('/dashboard')->with('msg', 'Jogo editado com sucesso!');
    }

    /**
     * Adiciona o usuário autenticado como participante de um jogo.
     */
    public function joinEvent(string $id): RedirectResponse
    {
        auth()->user()->jogosParticipants()->attach($id);
        $event = Jogo::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Sua presença no jogo: ' . $event->title . ' foi confirmada!');
    }

    /**
     * Remove o usuário autenticado da lista de participantes de um jogo.
     */
    public function leaveEvent(string $id): RedirectResponse
    {
        auth()->user()->jogosParticipants()->detach($id);
        $event = Jogo::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do jogo: ' . $event->title . '!');
    }
}