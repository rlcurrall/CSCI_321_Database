<?php include('view/header.php'); ?>
        <main>
            <h1>Login</h1>
            
            <!-- Show message for user login -->
            <?php
            
            if ( isset($login_message) )
            {
                ?>
                <p> <?php echo $login_message; ?> </p>
                <?php
            }
            
            ?>
            
            <form action="." method="post">
                <input type="hidden" name="action" value="verify_login">
                
                <label>Username:</label>
                <input type="text" name="username" placeholder="Username" required autofocus>
                <br>
                
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <br>
                
                <input type="submit" value="Login">
            </form>
            
            <form action="." method="post">
                <input type="hidden" name="action" value="show_register_form">
                <input type="submit" value="Register">
            </form>
        </main>

<?php include('view/footer.php'); ?>