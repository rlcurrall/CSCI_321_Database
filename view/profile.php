<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
?>
<div id="profile_body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <p>Characters</p>
        <p>Games</p>
    </aside>
    <main>
        <p><?php echo $_SESSION['is_valid_login']; ?></p>
        <p><?php echo $_SESSION['username']; ?></p>
        <p><?php echo $_SESSION['password']; ?></p>
        <br>
    
        <table>
        
        </table>
    
        <form action="." method="post">
            <input type="hidden" name="action" value="logout">
            <input type ="submit" value ="Logout">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');