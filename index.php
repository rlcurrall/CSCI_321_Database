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
        header('Location: index.php?action=view_characters');
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
    // LOGIN/REGISTRATION ACTIONS
    case 'login':
        $login_message = "";
        $_SESSION['username'] = filter_input(INPUT_POST, 'username');
        $_SESSION['password'] = filter_input(INPUT_POST, 'password');
        if (is_valid_login($_SESSION['username'], $_SESSION['password']))
        {
            $_SESSION['is_valid_login'] = true;
            header('Location: index.php?action=view_characters');
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
            $user = get_user($_SESSION['username']);
            $_SESSION['userID'] = $user['userID'];
            header('Location: index.php?action=view_characters');
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
    case 'show_register_form':
        $message = NULL;
        include('view/register.php');
        break;
    case 'register':
        $email = filter_input(INPUT_POST, 'email');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $name = filter_input(INPUT_POST, 'name');
        if (is_username_free($username)) {
            add_user($username, $name, $password, $email);
            $_SESSION = array();
            session_destroy();
            $login_message = "Login using your new username and password.";
            include('view/login.php');
        }
        else {
            $message = "Username is not available";
            include('view/register.php');
        }
        break;
    
    // CHARACTER ACTIONS
    case 'view_characters':
        include('view/characters.php');
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
        $characterPage = filter_input(INPUT_POST, 'page');
        $characterID = filter_input(INPUT_POST, 'character_id');
        include('view/edit_character_form.php');
        break;
    case 'edit_character' :
        $characterPage = filter_input(INPUT_POST, 'page');
        $characterID = filter_input(INPUT_POST, 'character_id');
        $name = filter_input(INPUT_POST, 'name');
        $background = filter_input(INPUT_POST, 'background');
        edit_character($characterID, $name, $background);
        if ( $characterPage ) {
            header('Location: index.php?action=character_page&characterID='.$characterID);
        }
        else {
            header('Location: .');
        }
        break;
    case 'character_page' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        include('view/character_page.php');
        break;
    case 'leave_game' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        leave_game($characterID);
        header('Location: index.php?action=character_page&characterID='.$characterID);
        break;
    
    // GAME ACTIONS
    case 'view_games' :
        include('view/games.php');
        break;
    case 'game_page' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        include('view/game_page.php');
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
        $gamePage = filter_input(INPUT_POST, 'page');
        $gameID = filter_input(INPUT_POST, 'game_id');
        include('view/edit_game_form.php');
        break;
    case 'edit_game' :
        $gamePage = filter_input(INPUT_POST, 'page');
        $gameID = filter_input(INPUT_POST, 'game_id');
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        edit_game($gameID, $name, $description);
        if ( $gamePage ) {
            header('Location: index.php?action=game_page&gameID='.$gameID);
        }
        else {
            header('Location: index.php?action=view_games');
        }
        break;
    case 'delete_game' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        delete_game($gameID);
        include('view/games.php');
        break;
    case 'join_game_form' :
        $charPage= filter_input(INPUT_POST, 'page');
        $characterID = filter_input(INPUT_POST, 'character_id');
        $character = get_character($characterID);
        include('view/join_game.php');
        break;
    case 'join_game' :
        $charPage = filter_input(INPUT_POST, 'page');
        $characterID = filter_input(INPUT_POST, 'character_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        join_game($gameID, $characterID);
        if ($charPage) {
            header('Location: index.php?action=character_page&characterID='.$_SESSION['joinCharacter']);
            $_SESSION['joinCharacter'] = NULL;
        }
        else {
            header('Location: index.php?action=view_characters');
            $_SESSION['joinCharacter'] = NULL;
        }
        break;
    case 'remove_from_game' :
        $characterID = filter_input(INPUT_POST, 'character_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        remove_player($characterID);
        header('Location: index.php?action=game_page&gameID='.$gameID);
        break;
    case 'add_log_form' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        include('view/add_log_form.php');
        break;
    case 'add_log' :
        $gameID = filter_input(INPUT_POST, 'game_id');
        $date = filter_input(INPUT_POST, 'date');
        $description = filter_input(INPUT_POST, 'description');
        add_log($gameID, $date, $description);
        header('Location: index.php?action=game_page&gameID='.$gameID);
        break;
    case 'delete_log' :
        $logID = filter_input(INPUT_POST, 'log_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        delete_log($logID);
        header('Location: index.php?action=game_page&gameID='.$gameID);
        break;
    case 'edit_log_form' :
        $logID = filter_input(INPUT_POST, 'log_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        include('view/edit_log_form.php');
        break;
    case 'edit_log' :
        $logID = filter_input(INPUT_POST, 'log_id');
        $gameID = filter_input(INPUT_POST, 'game_id');
        $date = filter_input(INPUT_POST, 'date');
        $description = filter_input(INPUT_POST, 'description');
        edit_log($logID, $date, $description);
        header('Location: index.php?action=game_page&gameID='.$gameID);
        break;
    
    // SEARCH ACTIONS
    case 'search' :
        // TODO 
        break;
}