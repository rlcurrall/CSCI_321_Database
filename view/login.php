<?php include('view/login_header.php'); ?>
        <main>
            <div class="form">
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
                
                    <span class="button-wrapper"><input class="button" 
                        style="width: 45%;" align="right" 
                        type="submit" value="Login"></span>
                </form>
            
                <form action="." method="post">
                    <input type="hidden" name="action" value="show_register_form">
                    <span class="button-wrapper"><input class="button" 
                        style="width: 45%;" type="submit" value="Register"></span>
                </form>
            </div>
        </main>

<?php include('view/footer.php'); 
    $login_message = "";
?>