<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $dsn = 'mysql:host=localhost;dbname=rcurrall';
    $usernameDB = 'mgs_user';
    $passwordDB = 'pa55word';
    // added to...
    //$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $db = new PDO($dsn, $usernameDB, $passwordDB);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include( 'errors/database_error.php');
        
        exit();
    }
?>