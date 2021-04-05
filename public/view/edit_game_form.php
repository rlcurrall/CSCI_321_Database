<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $game = get_game($gameID);
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <a class="aside_button" href="index.php?action=view_characters">Characters</a>
        <a class="aside_button" href="index.php?action=view_games">Games</a>
    </aside>
    <main class="profile-main">
        <h1>Edit Game</h1>
        <form action="." method="post" id="game_form">
            <input type="hidden" name="action" value="edit_game">
            <input type="hidden" name="game_id" value="<?php echo $gameID; ?>">
            
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $game['gameName']; ?>">
            <br>
            <br>
            
            <label>Background:</label>
            <textarea 
                name="description" 
                form="game_form" 
                rows="4" 
                cols="80"><?php echo $game['description']; ?></textarea>
            <br>
            
            <label>&nbsp;</label>
            <input type="hidden" name='page' value ='<?php echo $gamePage; ?>'>
            <input class="button" type="submit" value="Edit Game">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');