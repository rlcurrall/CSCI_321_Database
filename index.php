<?php 
// start session to keep track of values for login
session_start();

// connect to the database and load the function used
// to query the database
require_once('model/database.php');
require_once('model/user_db.php');

// check the action if it is null set the action to user_menu
$action = filter_input(INPUT_POST, 'action');
if ( $action == NULL )
{
    $action = filter_input(INPUT_GET, 'action');
    if ( $action == NULL )
    {
        $action = 'view_characters';
    } // end nested if
} // end if

// check if user is attempting to register an account or login already
// if not then check if 'is_valid_login is set
// if not then set $action to login
if ($action != 'verify_login'){
if ($action != 'register'){
    if ($action != 'show_register_form'){
        if ( !isset($_SESSION['is_valid_login']) )
        {
            $action = 'login';
        } // end second nested if statement
    } // end first nested if statement
} // end if statment
}

switch($action)
{
    case 'login':
        $login_message = "";
        $_SESSION['username'] = filter_input(INPUT_POST, 'username');
        $_SESSION['password'] = filter_input(INPUT_POST, 'password');
        if (is_valid_login($_SESSION['username'], $_SESSION['password']))
        {
            $_SESSION['is_valid_login'] = true;
            include('view/user_menu.php');
        }
        else
        {
            include('view/login.php');
        } // end if-else
        break;
    case 'verify_login':
        $_SESSION['username'] = filter_input(INPUT_POST, 'username');
        $_SESSION['password'] = filter_input(INPUT_POST, 'password');
        if (is_valid_login($_SESSION['username'], $_SESSION['password']))
        {
            $_SESSION['is_valid_login'] = true;
            include('view/characters.php');
        }
        else
        {
            $login_message = 'Incorrect username or password';
            include('view/login.php');
        } // end if-else
        break;
    case 'logout':
        $_SESSION = array();
        session_destroy();
        $login_message = 'You have been logged out.';
        include('view/login.php');
        break;
    case 'view_characters':
        include('view/characters.php');
        break;
    case 'show_register_form':
        include('view/register.php');
        break;
    case 'register':
        $email = filter_input(INPUT_POST, 'email');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $name = filter_input(INPUT_POST, 'name');
        add_user($username, $name, $password, $email);
        $_SESSION = array();
        session_destroy();
        $login_message = "Login using your new username and password.";
        include('view/login.php');
        break;
    case 'search' :
        // TODO 
        break;
    case 'add_character' :
        $userID = filter_input(INPUT_POST, 'user_id');
        $name = filter_input(INPUT_POST, 'name');
        $background = filter_input(INPUT_POST, 'background');
        add_character($userID, $name, $background);
        header('Location: .');
        break;
    case 'add_character_form':
        $user_id = filter_input(INPUT_POST, 'user_id');
        include('view/add_character_form.php');
        break;
    case 'delete_character' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        delete_character($characterID);
        include('view/characters.php');
        break;
    case 'edit_character_form' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        include('view/edit_character_form.php');
        break;
    case 'edit_character' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        $name = filter_input(INPUT_POST, 'name');
        $background = filter_input(INPUT_POST, 'background');
        edit_character($characterID, $name, $background);
        header('Location: .');
        break;
    case 'view_games' :
        include('view/games.php');
        break;
    case 'add_game_form' :
        $user_id = filter_input(INPUT_POST, 'user_id');
        include('view/add_game_form.php');
        break;
    case 'add_game' :
        $userID = filter_input(INPUT_POST, 'user_id');
        $name = filter_input(INPUT_POST, 'name');
        $background = filter_input(INPUT_POST, 'description');
        add_game($userID, $name, $background);
        header("Location: index.php?action=view_games");
        break;
    case 'edit_game_form' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        include('view/edit_game_form.php');
        break;
    case 'edit_game' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        edit_game($gameID, $name, $description);
        header('Location: index.php?action=view_games');
        break;
    case 'delete_game' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        delete_game($gameID);
        include('view/games.php');
        break;
    case 'join_game_form' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        $character = get_character($characterID);
        include('view/join_game.php');
        break;
    case 'join_game' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        join_game($gameID, $characterID);
        header('Location: index.php?action=view_characters');
        break;
    case 'create_game_form' :
        // TODO
        break;
    
}