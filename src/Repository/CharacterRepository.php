<?php

namespace ScrollLock\Repository;

use PDO;
use ScrollLock\Entity\Character;
use ScrollLock\Entity\Game;
use ScrollLock\Entity\User;

class CharacterRepository
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
                c.*,
                g.name AS game_name,
                g.description AS game_description,
                u.email,
                u.full_name
            FROM characters c
                JOIN users u ON c.user_id = u.id
                LEFT OUTER JOIN games g ON c.game_id = g.id
            ORDER BY c.name
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM characters
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

    public function find(int $id): ?Character
    {
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                c.*,
                g.name AS game_name,
                g.description AS game_description,
                u.email,
                u.full_name
            FROM characters c
                JOIN users u ON c.user_id = u.id
                LEFT OUTER JOIN games g ON c.game_id = g.id
            WHERE c.id = :id
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

    public function create(Character $character): Character
    {
        if ($character->getId()) {
            throw new \Exception('asdf');
        }

        $stmt = $this->conn->prepare(<<<SQL
            INSERT INTO characters
                (name, description, user_id, game_id)
            VALUES
                (:name, :description, :userId, :gameId)
        SQL);

        $stmt->bindParam(':name', $character->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $character->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':userId', $character->getUser()->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':gameId', $character->getGame()?->getId(), PDO::PARAM_STR);

        $stmt->execute();
        $character->setId($this->conn->lastInsertId());
        $stmt->closeCursor();

        return $character;
    }

    public function update(Character $character): Character
    {
        $stmt = $this->conn->prepare(<<<SQL
            UPDATE characters
            SET
                name = :name,
                description = :description,
                user_id = :userId,
                game_id = :gameId
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $character->getId());
        $stmt->bindParam(':name', $character->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $character->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':userId', $character->getUser()->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':gameId', $character->getGame()?->getId(), PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();

        return $character;
    }

    public function delete(Character $character): void
    {
        $stmt = $this->conn->prepare(<<<SQL
            DELETE FROM characters
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $character->getId());
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function findByUserId(int $userId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                c.*,
                g.name AS game_name,
                g.description AS game_description,
                u.email,
                u.full_name
            FROM characters c
                JOIN users u ON c.user_id = u.id
                LEFT OUTER JOIN games g ON c.game_id = g.id
            WHERE user_id = :id
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM characters
            WHERE user_id = :id
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

    public function findByGameId(int $gameId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                c.*,
                g.name AS game_name,
                g.description AS game_description,
                u.email,
                u.full_name
            FROM characters c
                JOIN users u ON c.user_id = u.id
                JOIN games g ON c.game_id = g.id
            WHERE game_id = :id
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->bindParam(':id', $gameId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM characters
            WHERE game_id = :id
        SQL);

        $stmt2->bindParam(':id', $gameId);
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
                ->setId((int) $row['user_id'])
                ->setEmail($row['email'])
                ->setFullName($row['full_name']);

            $character = (new Character())
                ->setId((int) $row['id'])
                ->setName($row['name'])
                ->setDescription($row['description'])
                ->setUser($user);

            if (isset($row['game_id'])) {
                $game = (new Game())
                    ->setId((int) $row['game_id'])
                    ->setName($row['game_name'])
                    ->setDescription($row['game_description']);
                $character->setGame($game);
            }

            $results[] = $character;
        }

        return $results;
    }
}
