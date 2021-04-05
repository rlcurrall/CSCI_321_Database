<?php

namespace ScrollLock\Repository;

use PDO;
use ScrollLock\Entity\User;

class UserRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function all(int $page = 1, int $limit = 25): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT * FROM users
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM users
        SQL);

        $stmt2->execute();
        $count = (int) $stmt2->fetch(PDO::FETCH_NUM)[0];
        $stmt2->closeCursor();

        return [
            'total' => $count,
            'page' => $page,
            'perPage' => $limit,
            'numPages' => ceil($count / $limit),
            'data' => $this->hydrate($results),
        ];
    }

    public function find(int $id): ?User
    {
        $stmt = $this->conn->prepare(<<<SQL
            SELECT *
            FROM users
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if (!isset($data['id'])) {
            return null;
        }

        $user = $this->hydrate([$data])[0];

        return $user;
    }

    public function create(User $user): User
    {
        if ($user->getId()) {
            throw new \Exception('asdf');
        }

        $stmt = $this->conn->prepare(<<<SQL
            INSERT INTO users
                (email, password, full_name)
            VALUES
                (:email, :password, :name)
        SQL);

        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':name', $user->getFullName(), PDO::PARAM_STR);
        $stmt->execute();
        $user->setId((int)$this->conn->lastInsertId());
        $stmt->closeCursor();

        return $user;
    }

    public function update(User $user): User
    {
        $stmt = $this->conn->prepare(<<<SQL
            UPDATE users
            SET
                full_name = :name,
                email = :email,
                password = :password
            WHERE id = :id
        SQL);

        $stmt->bindParam(':name', $user->getFullName(), PDO::PARAM_STR);
        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return $user;
    }

    public function delete(User $user): void
    {
        $stmt = $this->conn->prepare(<<<SQL
            DELETE FROM users
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $user->getId());
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->conn->prepare(<<<SQL
            SELECT *
            FROM users
            WHERE email = :email
        SQL);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if (!isset($data['id'])) {
            return null;
        }

        $user = $this->hydrate([$data])[0];

        return $user;
    }

    public function hydrate(array $rows): array
    {
        $results = [];

        foreach ($rows as $row) {
            $results[] = (new User())
                ->setId((int) $row['id'])
                ->setEmail($row['email'])
                ->setEncryptedPassword($row['password'])
                ->setFullName($row['full_name']);
        }

        return $results;
    }
}
