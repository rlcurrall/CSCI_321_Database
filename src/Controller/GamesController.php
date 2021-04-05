<?php

namespace ScrollLock\Controller;

use ScrollLock\Entity\Game;
use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\CharacterRepository;
use ScrollLock\Repository\GameLogRepository;
use ScrollLock\Repository\GameRepository;

class GamesController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $user = $request->getUser();
        $page = $request->get('page') ?? 1;
        $gamesRepo = new GameRepository($this->pdo);

        $games = $gamesRepo->findByUserId($user->getId(), $page);

        return $response->view('games/index', [
            'user' => $user,
            'games' => $games,
        ]);
    }

    public function show(Request $request, Response $response)
    {
        $user = $request->getUser();
        $gameId = $request->get('id');

        $gamesRepo = new GameRepository($this->pdo);
        $characterRepo = new CharacterRepository($this->pdo);
        $logRepo = new GameLogRepository($this->pdo);

        $game = $gamesRepo->find((int) $gameId);
        $players = $characterRepo->findByGameId($gameId);
        $logs = $logRepo->findByGameId($game->getId());

        return $response->view('games/show', [
            'user' => $user,
            'game' => $game,
            'players' => $players,
            'logs' => $logs,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $user = $request->getUser();

        return $response->view('games/create', [
            'user' => $user,
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $user = $request->getUser();
        $name = $request->get('name');
        $description = $request->get('description');

        $gameRepo = new GameRepository($this->pdo);

        $game = $gameRepo->create(
            (new Game())
                ->setName($name)
                ->setDescription($description)
                ->setOwner($user)
        );

        return $response->header("Location", "/games/{$game->getId()}");
    }

    public function edit(Request $request, Response $response)
    {
        $user = $request->getUser();
        $gameId = $request->get('id');

        $gamesRepo = new GameRepository($this->pdo);
        $game = $gamesRepo->find((int) $gameId); // todo: ensure user is owner

        return $response->view('games/edit', [
            'user' => $user,
            'game' => $game,
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $user = $request->getUser();
        $gameId = $request->get('id');

        $gamesRepo = new GameRepository($this->pdo);
        $game = $gamesRepo->find((int) $gameId); // TODO: check if user is owner

        if ($name = $request->get('name')) {
            $game->setName($name);
        }
        if ($description = $request->get('description')) {
            $game->setDescription($description);
        }

        $gamesRepo->update($game);

        return $response->header("Location", "/games/{$gameId}");
    }

    public function destroy(Request $request, Response $response)
    {
        $user = $request->getUser();
        $gameId = $request->get('id');

        $gamesRepo = new GameRepository($this->pdo);
        $game = $gamesRepo->find((int) $gameId);
        $gamesRepo->delete($game);

        return $response->header('Location', '/games');
    }
}
