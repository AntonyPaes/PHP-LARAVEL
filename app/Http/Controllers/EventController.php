<?php

namespace App\Http\Controllers;

use App\Models\Jogo;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Event;
class EventController extends Controller
{
    public function index()
    {
        $search = request('search');

        if ($search) {
            $events = Jogo::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $events = Jogo::all();
        }

        return view('welcome', [
            'events' => $events,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $jogo = new Jogo;

        $jogo->title = $request->title;
        $jogo->date = $request->date;
        $jogo->stadium = $request->stadium;
        $jogo->private = $request->private;
        $jogo->description = $request->description;
        $jogo->items = $request->items;

        //Imagem Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $jogo->image = $imageName;
        }
        $user = auth()->user();
        $jogo->user_id = $user->id;

        $jogo->save();

        return redirect('/')->with('msg', 'Jogo criado com sucesso!');
    }

    public function show($id)
    {
        $event = Jogo::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;
        if ($user) {
            $userEvents = $user->jogosParticipants->toArray();
            foreach ($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', [
            'event' => $event,
            'eventOwner' => $eventOwner,
            'hasUserJoined' => $hasUserJoined
        ]);
    }
}

    // Em app/Http/Controllers/EventController.php

    public function dashboard()
    {
        $user = auth()->user();

        // Busca os jogos que o usuário CRIOU (isso você já tinha)
        $events = $user->jogos;

        // Busca os jogos que o usuário PARTICIPA (esta é a parte nova)
        // Estou usando 'jogosParticipants' como o nome da relação no Model User
        $jogosAsParticipants = $user->jogosParticipants;

        // Envia AMBAS as variáveis para a view
        return view('events.dashboard', [
            'events' => $events,
            'jogosAsParticipants' => $jogosAsParticipants
        ]);
    }

    public function destroy($id)
    {
        // Corrigido: Usar o modelo Jogo em vez de Event
        Jogo::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Jogo excluído com sucesso!');
    }

    public function edit($id)
    {
        $user = auth()->user();

        // Busca o jogo pelo ID
        $event = Jogo::findOrFail($id);

        // Verifica se o usuário logado é o dono do jogo
        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        // Retorna a view de edição, passando os dados do jogo encontrado
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // Lógica para upload da imagem
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }

        // Garantir que a coluna 'items' seja tratada como array
        if (!isset($data['items'])) {
            $data['items'] = [];
        }

        // Busca o jogo pelo ID e atualiza os dados
        Jogo::findOrFail($id)->update($data);

        return redirect('/dashboard')->with('msg', 'Jogo editado com sucesso!');
    }

    public function joinEvent($id)
    {
        $user = auth()->user();
        $user ->jogosParticipants()->attach($id);

        $event = Jogo::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Sua presença no jogo: ' . $event->title . ' foi confirmada!');
    }

    public function leaveEvent($id)
    {
        $user = auth()->user();
        $user->jogosParticipants()->detach($id);

        $event = Jogo::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do jogo: ' . $event->title . '!');
    }

}