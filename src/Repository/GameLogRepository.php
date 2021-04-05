<?php

namespace ScrollLock\Repository;

use DateTime;
use PDO;
use ScrollLock\Entity\Game;
use ScrollLock\Entity\GameLog;
use ScrollLock\Entity\User;

class GameLogRepository
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
            SELECT
                l.*,
                g.name AS game_name,
                g.description AS game_description,
                u.id AS user_id,
                u.email AS user_email,
                u.full_name AS user_full_name
            FROM game_logs l
                JOIN games g ON l.game_id = g.id
                JOIN users u ON g.owner_id = u.id
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM game_logs
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

    public function find(int $id): ?GameLog
    {
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                l.*,
                g.name AS game_name,
                g.description AS game_description,
                u.id AS user_id,
                u.email AS user_email,
                u.full_name AS user_full_name
            FROM game_logs l
                JOIN games g ON l.game_id = g.id
                JOIN users u ON g.owner_id = u.id
            WHERE l.id = :id
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

    public function create(GameLog $user): GameLog
    {
        if ($user->getId()) {
            throw new \Exception('asdf');
        }

        $stmt = $this->conn->prepare(<<<SQL
            INSERT INTO game_logs
                (date, description, game_id)
            VALUES
                (:date, :description, :gameId)
        SQL);

        $stmt->bindParam(':date', $user->getDate()->format('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindParam(':description', $user->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':gameId', $user->getGame()->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $user->setId((int) $this->conn->lastInsertId());
        $stmt->closeCursor();

        return $user;
    }

    public function update(GameLog $log): GameLog
    {
        $stmt = $this->conn->prepare(<<<SQL
            UPDATE game_logs
            SET
                date = :date,
                description = :description
            WHERE id = :id
        SQL);

        $stmt->bindParam(':date', $log->getDate()->format('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindParam(':description', $log->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $log->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        return $log;
    }

    public function delete(GameLog $log): void
    {
        $stmt = $this->conn->prepare(<<<SQL
            DELETE FROM game_logs
            WHERE id = :id
        SQL);

        $stmt->bindParam(':id', $log->getId());
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function findByGameId(int $gameId, int $page = 1, int $limit = 25): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare(<<<SQL
            SELECT
                l.*,
                g.name AS game_name,
                g.description AS game_description,
                u.id AS user_id,
                u.email AS user_email,
                u.full_name AS user_full_name
            FROM game_logs l
                JOIN games g ON l.game_id = g.id
                JOIN users u ON g.owner_id = u.id
            WHERE g.id = :gameId
            ORDER BY l.date DESC
            LIMIT {$limit} OFFSET {$offset}
        SQL);

        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $stmt2 = $this->conn->prepare(<<<SQL
            SELECT count(*) FROM game_logs
            WHERE game_id = :gameId
        SQL);

        $stmt2->bindParam(':gameId', $gameId, PDO::PARAM_INT);
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

    public function hydrate(array $rows): array
    {
        $results = [];

        foreach ($rows as $row) {
            $user = (new User())
                ->setId((int) $row['user_id'])
                ->setFullName($row['user_full_name'])
                ->setEmail($row['user_email']);

            $game = (new Game())
                ->setId($row['game_id'])
                ->setName($row['game_name'])
                ->setDescription('game_description')
                ->setOwner($user);

            $results[] = (new GameLog())
                ->setId((int) $row['id'])
                ->setGame($game)
                ->setDescription($row['description'])
                ->setDate(new DateTime($row['date']));
        }

        return $results;
    }
}
