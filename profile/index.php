<?php
require '../model/database.php';

$user = getUser($_SESSION['login_user']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
    </head>
    <body>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Password: <?php echo $user['password'] ?></p>
    </body>
</html>