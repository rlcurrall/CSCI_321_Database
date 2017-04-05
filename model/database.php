<?php
    $dsn = 'mysql:host=localhost;dbname=scroll_lock';
    $usernameDB = 'mgs_user';
    $passwordDB = 'pa55word';
    // added to...
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $db = new PDO($dsn, $usernameDB, $passwordDB, $options);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
?>