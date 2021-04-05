<?php

namespace ScrollLock\Controller;

use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\UserRepository;

class AuthenticationController extends Controller
{
    public function showLogin(Request $request, Response $response)
    {
        if ($request->getUser()) {
            return $response->header('Location', '/characters');
        }

        return $response->view('login');
    }

    public function attemptLogin(Request $request, Response $response)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $userRepo = new UserRepository($this->pdo);
        $user = $userRepo->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return $response->header('Location', '/login');
        }

        $request->setUser($user);

        return $response->header('Location', '/characters');
    }

    public function logout(Request $request, Response $response)
    {
        session_unset();
        session_destroy();

        return $response->header('Location', '/login');
    }
}
