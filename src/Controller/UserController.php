<?php

namespace ScrollLock\Controller;

use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\UserRepository;

class UserController extends Controller
{
    public function show(Request $request, Response $response)
    {
        $user = $request->getUser();

        return $response->view('profile/show', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request, Response $response)
    {
        $user = $request->getUser();

        return $response->view('profile/edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $user = $request->getUser();
        $userRepo = new UserRepository($this->pdo);

        if ($name = $request->get('name')) {
            $user->setFullName($name);
        }
        if ($email = $request->get('email')) {
            $user->setEmail($email);
        }
        if ($password = $request->get('password')) {
            $user->setPassword($password);
        }

        $userRepo->update($user);

        return $response->header('Location', '/profile');
    }
}
