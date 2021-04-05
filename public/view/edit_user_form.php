<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <a class="aside_button" href="index.php?action=view_characters">Characters</a>
        <a class="aside_button" href="index.php?action=view_games">Games</a>
    </aside>
    <main class="profile-main">
        <h1>Edit User</h1>
        <form action="." method="post">
            <input type="hidden" name="action" value="edit_user">
            <input type="hidden" name="user_id" value="<?php echo $user['userID']; ?>">
            
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>">
            <br>
            <br>
            
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $user['email']; ?>">
            <br>
            <br>
            
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $user['password']; ?>">
            <br>
            <br>
            
            <label>&nbsp;</label>
            <input class="button" type="submit" value="Edit User">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');