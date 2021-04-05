<?php

namespace ScrollLock\Repository;

use PDO;
use ScrollLock\Entity\Game;
use ScrollLock\Entity\User;

class GameRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function all(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                g.*,
                u.email,
                u.password,
                u.full_name
            FROM games g
                JOIN users u ON g.owner_id = u.id
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM games
        SQL);

        $stmt2->execute();
        $count = (int) $stmt2->fetch(PDO::FETCH_NUM)[0];
        $stmt2->closeCursor();

        return [
            'total' => $count,
            'page' => $page,
            'from' => $offset + 1,
            'to' => $offset + $limit,
            'perPage' => $limit,
            'numPages' => ceil($count / $limit),
            'data' => $this->hydrate($results),
        ];
    }

    public function find(int $id): ?Game
    {
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                g.*,
                u.email,
                u.password,
                u.full_name
            FROM games g
                JOIN users u ON u.id = g.owner_id
            WHERE g.id = :id
        SQL);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if (!isset($data['id'])) {
            return null;
        }

        $game = $this->hydrate([$data])[0];

        return $game;
    }

    public function create(Game $game): Game
    {
        if ($game->getId()) {
            throw new \Exception('asdf');
        }

        $stmt = $this->conn->prepare(<<<SQL
            INSERT INTO games
                (name, description, owner_id)
            VALUES
                (:name, :description, :ownerId)
        SQL);

        $stmt->bindParam(':name', $game->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $game->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':ownerId', $game->getOwner()->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $game->setId($this->conn->lastInsertId());
        $stmt->closeCursor();

        return $game;
    }

    public function update(Game $game): Game
    {
        $stmt = $this->conn->prepare(<<<SQL
            UPDATE games
            SET
                name = :name,
                description = :description,
                owner_id = :ownerId
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $game->getId());
        $stmt->bindParam(':name', $game->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $game->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':ownerId', $game->getOwner()->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return $game;
    }

    public function delete(Game $game): void
    {
        $stmt = $this->conn->prepare(<<<SQL
            DELETE FROM games
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $game->getId());
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function findByUserId(int $userId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                g.*,
                u.email,
                u.password,
                u.full_name
            FROM games g
                JOIN users u ON u.id = g.owner_id
            WHERE owner_id = :id
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM games
            WHERE owner_id = :id
        SQL);

        $stmt2->bindParam(':id', $userId);
        $stmt2->execute();
        $count = (int) $stmt2->fetch(PDO::FETCH_NUM)[0];
        $stmt2->closeCursor();

        return [
            'total' => $count,
            'page' => $page,
            'from' => $offset + 1,
            'to' => $offset + $limit,
            'perPage' => $limit,
            'numPages' => ceil($count / $limit),
            'data' => $this->hydrate($results),
        ];
    }

    public function hydrate(array $rows): array
    {
        $results = [];

        foreach ($rows as $row) {
            $user = (new User())
                ->setId((int) $row['owner_id'])
                ->setEmail($row['email'])
                ->setFullName($row['full_name']);

            $game = (new Game())
                ->setId((int) $row['id'])
                ->setName($row['name'])
                ->setDescription($row['description'])
                ->setOwner($user);

            $results[] = $game;
        }

        return $results;
    }
}
