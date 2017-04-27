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
        $action = 'profile';
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
            include('view/profile.php');
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
    case 'profile':
        include('view/profile.php');
        break;
    case 'show_register_form':
        include('view/register.php');
        break;
    case 'register':
        $email = filter_input(INPUT_POST, 'email');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        add_user($username, $password, $email);
        $_SESSION = array();
        session_destroy();
        $lgoin_message = "Login using your new username and password.";
        include('view/login.php');
        break;
    case 'search' :
        // TODO 
        break;
    case 'view_characters' :
        // TODO
        break;
    case 'add_character' :
        // TODO
        break;
    case 'add_character_form':
        // TODO
        break;
    case 'view_games' :
        // TODO
        break;
    case 'join_game' :
        // TODO
        break;
    case 'create_game' :
        // TODO
        break;
    case 'create_game_form' :
        // TODO
        break;
    
}