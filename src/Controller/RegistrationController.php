<?php

namespace ScrollLock\Controller;

use ScrollLock\Entity\User;
use ScrollLock\Http\Controller;
use ScrollLock\Http\Request;
use ScrollLock\Http\Response;
use ScrollLock\Repository\UserRepository;

class RegistrationController extends Controller
{

    public function showRegister(Request $request, Response $response)
    {
        return $response->view('register');
    }

    public function register(Request $request, Response $response)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $fullName = $request->get('full_name');

        $repo = new UserRepository($this->pdo);

        if ($repo->findByEmail($email)) {
            return $response->view('register', [
                'message' => "Username is not available",
            ]);
        }

        $repo->create(
            (new User())
                ->setEmail($email)
                ->setFullName($fullName)
                ->setPassword($password)
        );

        return $response->header('Location', '/login');
    }
}
