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
        <h1>Add Character</h1>
        <form action="." method="post" id="character_form">
            <input type="hidden" name="action" value="add_character">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            
            <label>Name:</label>
            <input type="text" name="name">
            <br>
            <br>
            
            <label>Background:</label>
            <textarea name="background" form="character_form" rows="4" cols="80"></textarea>
            <br>
            
            <label>&nbsp;</label>
            <input class="button" type="submit" value="Add Character">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');