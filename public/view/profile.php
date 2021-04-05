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
        <h1 class="gamePageTitle"><?php echo $user['username'] ?></h1>
        <form action="." method="post" class="gameEditButton">
                <input type="hidden" name="action"
                       value="edit_user_form">
                <input type="submit" class="button" value="Edit">
            </form>
        <div class="gameDescription">
            <h3>Name</h3>
            <p><?php echo $user['name']; ?></p>
        </div>
        <div class="gameLog">
            <h3>Email</h3>
            <p><?php echo $user['email']; ?></p>
        </div>
    </main>
</div>

<?php
    include('view/footer.php');