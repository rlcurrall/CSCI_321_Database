<?php

namespace ScrollLock\Factory;

use ScrollLock\Controller\AuthenticationController;
use ScrollLock\Controller\CharacterGameController;
use ScrollLock\Controller\CharactersController;
use ScrollLock\Controller\GameLogsController;
use ScrollLock\Controller\GamesController;
use ScrollLock\Controller\RegistrationController;
use ScrollLock\Controller\UserController;
use ScrollLock\Http\Router;

class RouterFactory
{
    public static function make(array $arguments): Router
    {
        $router = new Router($arguments);

        $router
            ->register('GET', 'login', AuthenticationController::class, 'showLogin', true)
            ->register('POST', 'login', AuthenticationController::class, 'attemptLogin', true)
            ->register('GET', 'logout', AuthenticationController::class, 'logout')

            ->register('GET', 'register', RegistrationController::class, 'showRegister', true)
            ->register('POST', 'register', RegistrationController::class, 'register', true)

            ->register('GET', 'profile', UserController::class, 'show')
            ->register('GET', 'profile/edit', UserController::class, 'edit')
            ->register('PUT', 'profile', UserController::class, 'update')

            ->register('GET', 'characters', CharactersController::class, 'index')
            ->register('GET', 'characters/create', CharactersController::class, 'create')
            ->register('GET', 'characters/{id}', CharactersController::class, 'show')
            ->register('POST', 'characters', CharactersController::class, 'store')
            ->register('GET', 'characters/{id}/edit', CharactersController::class, 'edit')
            ->register('PUT', 'characters/{id}', CharactersController::class, 'update')
            ->register('DELETE', 'characters/{id}', CharactersController::class, 'destroy')

            ->register('GET', 'games', GamesController::class, 'index')
            ->register('GET', 'games/create', GamesController::class, 'create')
            ->register('GET', 'games/{id}', GamesController::class, 'show')
            ->register('POST', 'games', GamesController::class, 'store')
            ->register('GET', 'games/{id}/edit', GamesController::class, 'edit')
            ->register('PUT', 'games/{id}', GamesController::class, 'update')
            ->register('DELETE', 'games/{id}', GamesController::class, 'destroy')

            ->register('GET', 'game-logs', GameLogsController::class, 'index')
            ->register('GET', 'game-logs/{id}', GameLogsController::class, 'show')
            ->register('GET', 'games/{gameId}/log/create', GameLogsController::class, 'create')
            ->register('POST', 'games/{gameId}/log', GameLogsController::class, 'store')
            ->register('GET', 'game-logs/{id}/edit', GameLogsController::class, 'edit')
            ->register('PUT', 'game-logs/{id}', GameLogsController::class, 'update')
            ->register('DELETE', 'game-logs/{id}', GameLogsController::class, 'destroy')

            ->register('GET', 'characters/{id}/game/join', CharacterGameController::class, 'join')
            ->register('POST', 'characters/{id}/game', CharacterGameController::class, 'add')
            ->register('DELETE', 'characters/{id}/game', CharacterGameController::class, 'remove');

        return $router;
    }
}
