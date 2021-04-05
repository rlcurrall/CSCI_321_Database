<?php

namespace ScrollLock\Controller;

use ScrollLock\Entity\Character;
use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\CharacterRepository;

class CharactersController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $user = $request->getUser();
        $page = $request->get('page') ?? 1;
        $characterRepo = new CharacterRepository($this->pdo);

        $characters = $characterRepo->findByUserId($user->getId(), $page);

        return $response->view('characters/index', [
            'characters' => $characters,
            'user' => $user,
        ]);
    }

    public function show(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = $request->get('id');

        $characterRepo = new CharacterRepository($this->pdo);
        $character = $characterRepo->find((int) $characterId);

        return $response->view('characters/show', [
            'user' => $user,
            'character' => $character,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $user = $request->getUser();

        return $response->view('characters/create', [
            'user' => $user,
        ]);
    }

    public function store(Request $request, Response $response)
    {
        $user = $request->getUser();
        $name = $request->get('name');
        $description = $request->get('description');

        $characterRepo = new CharacterRepository($this->pdo);
        $character = $characterRepo->create(
            (new Character())
                ->setName($name)
                ->setDescription($description)
                ->setUser($user)
        );

        return $response->header('Location', "/characters/{$character->getId()}");
    }

    public function destroy(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = (int) $request->get('id');
        $characterRepo = new CharacterRepository($this->pdo);

        $character = $characterRepo->find($characterId);

        if ($character && $character->getUser()->getId() === $user->getId()) {
            // TODO: 403
        }

        $characterRepo->delete($character);

        return $response->header('Location', '/characters');
    }

    public function edit(Request $request, Response $response)
    {
        $user = $request->getUser();
        $characterId = $request->get('id');

        $characterRepo = new CharacterRepository($this->pdo);
        $character = $characterRepo->find($characterId);

        return $response->view('characters/edit', [
            'character' => $character,
            'user' => $user,
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $user = $request->getUser(); // todo: check that user is owner
        $characterId = $request->get('id');
        $name = $request->get('name');
        $description = $request->get('description');

        $characterRepo = new CharacterRepository($this->pdo);

        $character = $characterRepo->find($characterId);
        $character->setName($name)->setDescription($description);
        $characterRepo->update($character);

        return $response->header("Location", "/characters/{$characterId}");
    }
}
