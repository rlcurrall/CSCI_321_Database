<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $character = get_character($characterID);
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <a class="aside_button" href="index.php?action=view_characters">Characters</a>
        <a class="aside_button" href="index.php?action=view_games">Games</a>
    </aside>
    <main class="profile-main">
        <h1>Edit Character</h1>
        <form action="." method="post" id="character_form">
            <input type="hidden" name="action" value="edit_character">
            <input type="hidden" name="character_id" value="<?php echo $characterID; ?>">
            
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $character['characterName']; ?>">
            <br>
            <br>
            
            <label>Background:</label>
            <textarea name="background" form="character_form" rows="4" cols="80"><?php echo $character['background']; ?></textarea>
            <br>
            
            <label>&nbsp;</label>
            <input type="hidden" name='page' value ='<?php echo $characterPage; ?>'>
            <input class="button" type="submit" value="Edit Character">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');