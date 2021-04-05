<?php

namespace ScrollLock\Factory;

use PDO;

class DatabaseFactory
{
    public static function make(): PDO
    {
        $host = getenv('DB_HOST');
        $name = getenv('DB_NAME');
        $password = getenv('DB_PASSWORD');
        $username = getenv('DB_USERNAME');

        return new PDO(
            "mysql:host={$host};dbname={$name}",
            $username,
            $password,
        );
    }
}
