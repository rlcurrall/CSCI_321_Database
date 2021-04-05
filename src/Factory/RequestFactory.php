<?php

namespace ScrollLock\Factory;

use PDO;
use ScrollLock\Http\Request;
use ScrollLock\Repository\UserRepository;

class RequestFactory
{
    public static function make(PDO $pdo): Request
    {
        $request = new Request();

        $userId = $_SESSION['auth_user_id'] ?? null;

        if ($userId) {
            $user = (new UserRepository($pdo))->find((int) $userId);
            $request->setUser($user);
        }

        return $request;
    }
}
