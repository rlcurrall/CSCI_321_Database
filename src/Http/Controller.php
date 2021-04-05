<?php

namespace ScrollLock\Http;

use PDO;

abstract class Controller
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
