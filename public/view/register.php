<?php include('view/login_header.php'); ?>
        <main>
            <div class="form">
            <h1>Register</h1>
            <?php if ($message != NULL) { ?>
            <p style="color: red;"><?php echo $message ?></p>
            <?php } ?>
            
            <form action="." method="post">
                <input type="hidden" name="action" value="register">
                
                <label>Email:</label>
                <input type="email" name="email" placeholder="email@domain.com" required autofocus>
                <br>
                
                <label>Name:</label>
                <input type="text" name="name" placeholder="Your name">
                <br>
                
                <label>Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <br>
                
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <br>
                
                <span class="button-wrapper"><input class="button" type="submit" value="Register"><span>
            </form>
            </div>
        </main>

<?php include('view/footer.php'); ?>