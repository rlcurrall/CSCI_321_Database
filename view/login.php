<?php include('view/login_header.php'); ?>
        <main>
            <div id="form">
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
                
                    <span id="button-wrapper"><input id="button" align="right" type="submit" value="Login"></span>
                </form>
            
                <form action="." method="post">
                    <input type="hidden" name="action" value="show_register_form">
                    <span id="button-wrapper"><input id="button" type="submit" value="Register"></span>
                </form>
            </div>
        </main>

<?php include('view/footer.php'); ?>