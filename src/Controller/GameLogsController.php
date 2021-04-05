<?php

namespace ScrollLock\Controller;

use DateTime;
use ScrollLock\Entity\GameLog;
use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\GameLogRepository;
use ScrollLock\Repository\GameRepository;

class GameLogsController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $response->header('Location', '/characters');
    }

    public function show(Request $request, Response $response)
    {
        return $response->header('Location', '/characters');
    }

    public function create(Request $request, Response $response)
    {
        $user = $request->getUser();
        $gameId = $request->get('gameId');

        $gamesRepo = new GameRepository($this->pdo);
        $game = $gamesRepo->find((int) $gameId);

        return $response->view('game_logs/create', [
            'user' => $user,
            'game' => $game,
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $user = $request->getUser(); // todo: check that user is owner of game.
        $gameId = $request->get('gameId');
        $date = $request->get('date');
        $description = $request->get('description');

        $logRepo = new GameLogRepository($this->pdo);
        $gameRepo = new GameRepository($this->pdo);

        $game = $gameRepo->find($gameId);
        $logRepo->create(
            (new GameLog())
                ->setDate(new DateTime($date))
                ->setDescription($description)
                ->setGame($game)
        );

        return $response->header("Location", "/games/{$gameId}");
    }

    public function edit(Request $request, Response $response)
    {
        $user = $request->getUser();
        $logId = $request->get('id');

        $logRepo = new GameLogRepository($this->pdo);
        $log = $logRepo->find((int) $logId);

        return $response->view('game_logs/edit', [
            'user' => $user,
            'log' => $log,
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $user = $request->getUser(); // todo: ensure user is owner
        $logId = $request->get('id');
        $date = $request->get('date');
        $description = $request->get('description');

        $logRepo = new GameLogRepository($this->pdo);
        $log = $logRepo->find($logId)
            ->setDate(new DateTime($date))
            ->setDescription($description);

        $logRepo->update($log);

        return $response->header("Location", "/games/{$log->getGame()->getId()}");
    }

    public function destroy(Request $request, Response $response)
    {
        $user = $request->getUser(); // todo: ensure user is owner
        $logId = $request->get('id');

        $logRepo = new GameLogRepository($this->pdo);
        $log = $logRepo->find($logId);
        $game = $log->getGame();
        $logRepo->delete($log);

        return $response->header("Location", "/games/{$game->getId()}");
    }
}
