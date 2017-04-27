<?php

/////////////////////////// LOGIN FUNCTIONS ///////////////////////////
function add_user($username, $password, $email)
{
    global $db;
    // $new_password = sha1($username . $password);
    $query = 'INSERT INTO users
              (username, email, password)
              VALUES
              (:username, :email, :password)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
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
    
    $query = 'SELECT characters.name, characters.image, games.name
              FROM characters
              LEFT OUTER JOIN games
              ON characters.gameID = games.gameID
              WHERE userID = :userID
              ORDER BY characters.name';
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
    
    $query = 'SELECT characters.name, characters.image, characters.background,
                     games.name, games.gameID
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

function add_character($userID, $name, $image, $background)
{
    global $db;
    
    $query = 'INSERT INTO characters
              ( userID, name, background )
              VALUES
              ( :userID, :name, :background )';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $userID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':image', $image);
    $statement->bindValue(':background', $background);
    $statement->execute();
    $statement->closeCursor();
}

function edit_character($characterID, $name, $image, $background)
{
    global $db;
    
    $query = 'UPDATE characters
              SET name = :name,
                  background = :background
              WHERE characterID = :characterID';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $characterID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':image', $image);
    $statement->bindValue(':background', $background);
    $statement->execute();
    $statement->closeCursor();
}

function delete_character($characterID)
{
    global $db;
    
    $query = 'DELETE FROM character
              WHERE characterID = :characterID';
    $statement = $db->prepare($query);
    $statement->bindValue(':characterID', $characterID);
    $statement->execute();
    $statement-closeCursor();
}

function search_character($keyword)
{
    global $db;
    
    $query = "SELECT * FROM characters
              WHERE name LIKE CONCAT('%', :keyword, '%')";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':keyword', $keyword);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    return $users;
}

/////////////////////////// GAME FUNCTIONS ///////////////////////////

function get_games($userID)
{
    global $db;
    
    $query = 'SELECT games.name, games.adminID
              FROM games
              INNER JOIN characters
              ON games.gameID = characters.gameID
              WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $games = $statement->fetchAll();
    $statement->closeCursor();
    return $games;
}

function get_admin_games($userID)
{
    global $db;
    
    $query = 'SELECT games.name
              FROM games
              INNER JOIN users
              ON games.adminID = users.userID
              WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $admin_games = $statement->fetchAll();
    $statement->closeCursor();
    return $admin_games;
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

function search_games($keyword)
{
    global $db;
    
    $query = "SELECT games.name 
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
    
    $query = "";
    $statement = $db->prepare($query);
    
    $statement->execute();
    
}

?>