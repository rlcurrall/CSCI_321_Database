<?php

namespace ScrollLock\Controller;

use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\CharacterRepository;
use ScrollLock\Repository\GameRepository;

class CharacterGameController extends Controller
{
    public function join(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = $request->get('id');
        $page = $request->get('page') ?? 1;

        $characterRepo = new CharacterRepository($this->pdo);
        $gamesRepo = new GameRepository($this->pdo);

        $character = $characterRepo->find((int) $characterId);
        $games = $gamesRepo->all($page);

        return $response->view('games/join', [
            'character' => $character,
            'user' => $user,
            'games' => $games,
        ]);
    }

    public function add(Request $request, Response $response)
    {
        $user = $request->getUser(); // TODO: check if character owner
        $characterId = $request->get('id');
        $gameId = $request->get('gameId');

        $gamesRepo = new GameRepository($this->pdo);
        $characterRepo = new CharacterRepository($this->pdo);

        $game = $gamesRepo->find($gameId);
        $character = $characterRepo->find((int) $characterId);
        $character->setGame($game);
        $characterRepo->update($character);

        return $response->header("Location", "/characters/{$character->getId()}");
    }

    public function leave(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = $request->get('id');

        $characterRepo = new CharacterRepository($this->pdo);

        $character = $characterRepo->find($characterId);
        $character->setGame(null);
        $characterRepo->update($character);

        return $response->header("Location", "/characters/{$characterId}");
    }

    public function remove(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = $request->get('id');

        $characterRepo = new CharacterRepository($this->pdo);

        $character = $characterRepo->find($characterId);
        $gameId = $character->getGame()->getId();
        $character->setGame(null);
        $characterRepo->update($character);

        return $response->header("Location", "/games/{$gameId}");
    }
}
