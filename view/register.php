<?php include('view/login_header.php'); ?>
        <main>
            <div id="form">
            <h1>Register</h1>
            
            <form action="." method="post">
                <input type="hidden" name="action" value="register">
                
                <label>Email:</label>
                <input type="email" name="email" placeholder="email@domain.com"required autofocus>
                <br>
                
                <label>Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <br>
                
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <br>
                
                <span id="button-wrapper"><input id="button" type="submit" value="Register"><span>
            </form>
            </div>
        </main>

<?php include('view/footer.php'); ?>