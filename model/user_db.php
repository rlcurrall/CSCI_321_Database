<?php

/////////////////////////// LOGIN FUNCTIONS ///////////////////////////
function add_user($username, $name, $password, $email)
{
    global $db;
    // $new_password = sha1($username . $password);
    $query = 'INSERT INTO users
              (username, name, email, password)
              VALUES
              (:username, :name, :email, :password)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();
} // end add_user function

function is_username_free($username)
{
    global $db;
    $query = 'SELECT userID FROM users
              WHERE username = :username';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $free = !($statement->rowCount() == 1);
    $statement->closeCursor();
    return $free;
}

function is_valid_login($username, $password)
{
    global $db;
    // $password = sha1($username . $password);
    $query = 'SELECT userID FROM users
              WHERE username = :username 
              AND password = :password';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
} // end is_valid_login function


/////////////////////////// USER FUNCTIONS ///////////////////////////

function get_user($username)
{
    global $db;
    
    $query = 'SELECT * FROM users
              WHERE username = :username';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function search_users($keyword)
{
    global $db;
    
    $query = "SELECT * FROM users
              WHERE username LIKE CONCAT('%', :keyword, '%')";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', $keyword);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    return $users;
}


/////////////////////////// CHARACTER FUNCTIONS ///////////////////////////

function get_characters($userID)
{
    global $db;
    
    $query = 'SELECT characters.characterID, characters.characterName, 
        characters.background, games.gameName, games.gameID
              FROM characters
              LEFT OUTER JOIN games
              ON characters.gameID = games.gameID
              WHERE userID = :userID
              ORDER BY characters.characterName';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $characters = $statement->fetchAll();
    $statement->closeCursor();
    return $characters;
}

function get_character($characterID)
{
    global $db;
    
    $query = 'SELECT characters.characterID, characters.characterName, 
        characters.background, games.gameName, games.gameID
              FROM characters
              LEFT JOIN games
              ON characters.gameID = games.gameID
              WHERE characterID = :characterID';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $characterID);
    $statement->execute();
    $character = $statement->fetch();
    $statement->closeCursor();
    return $character;
}

function add_character($userID, $name, $background)
{
    global $db;
    $query = 'INSERT INTO characters
              ( userID, characterName, background )
              VALUES
              ( :userID, :characterName, :background )';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':characterName', $name);
    $statement->bindValue(':background', $background);
    $statement->execute();
    $statement->closeCursor();
}

function edit_character($characterID, $name, $background)
{
    global $db;
    $query = 'UPDATE characters
              SET characterName = :name,
                  background = :background
              WHERE characterID = :characterID';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $characterID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':background', $background);
    $statement->execute();
    $statement->closeCursor();
}

function delete_character($characterID)
{
    global $db;
    
    $query = 'DELETE FROM characters
              WHERE characterID = :characterID';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $characterID);
    $statement->execute();
    $statement->closeCursor();
}

function search_character($keyword)
{
    global $db;
    
    $query = "SELECT * FROM characters
              WHERE characterName LIKE CONCAT('%', :keyword, '%')";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', $keyword);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    return $users;
}

/////////////////////////// GAME FUNCTIONS ///////////////////////////

function num_games()
{
    global $db;
    $query = 'SELECT COUNT(*) AS total
              FROM games';
    $statement = $db->prepare($query);
    $statement->execute();
    $numRows = fetch($statement);
    $statement->closeCursor();
    return $numRows;
}
function get_games($userID)
{
    global $db;
    $query = 'SELECT games.gameName, games.description, games.gameID
              FROM games
              INNER JOIN users
              ON games.adminID = users.userID
              WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $games = $statement->fetchAll();
    $statement->closeCursor();
    return $games;
}

function get_game($gameID)
{
    global $db;
    
    $query = 'SELECT *
              FROM games
              WHERE gameID = :gameID';
    $statement = $db->prepare($query);
    $statement->bindValue(':gameID', $gameID);
    $statement->execute();
    $game = $statement->fetch();
    $statement->closeCursor();
    return $game;
}

function all_games()
{
    global $db;
    
    $query = 'SELECT games.gameID, 
                     games.gameName, 
                     games.description, 
                     users.username
              FROM games
              INNER JOIN users
              ON games.adminID = users.userID';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_games = $statement->fetchAll();
    $statement->closeCursor();
    return $all_games;
}

function add_game($userID, $name, $description)
{
    global $db;
    $query = 'INSERT INTO games
              ( adminID, gameName, description )
              VALUES
              ( :userID, :gameName, :description )';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':gameName', $name);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}

function delete_game($gameID)
{
    global $db;
    
    $query = 'DELETE FROM games
              WHERE gameID = :gameID';
    $statement = $db->prepare($query);
    $statement->bindValue(':gameID', $gameID);
    $statement->execute();
    $statement->closeCursor();
}

function edit_game($gameID, $name, $description)
{
    global $db;
    $query = 'UPDATE `games` 
                    SET 
                        `gameName` = :name,
                        `description` = :description
                    WHERE gameID = :gameID';
    $statement = $db->prepare($query);
    $statement->bindValue(':gameID', $gameID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}

function search_games($keyword)
{
    global $db;
    
    $query = "SELECT games.gameName 
              FROM games
              INNER JOIN users
              ON games.adminID = users.userID
              WHERE games.name LIKE CONCAT('%', :keyword, '%')";
    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', $keyword);
    $statement->execute();
    $games = $statement->fetchAll();
    $statement->closeCursor();
    return $games;
}

function join_game($gameID, $characterID)
{
    global $db;
    
    $query = "UPDATE characters
                SET gameID = :gameID
                WHERE characterID = :characterID";
    $statement = $db->prepare($query);
    $statement->bindValue(':gameID', $gameID);
    $statement->bindValue(':characterID', $characterID);
    $statement->execute();
}

?>