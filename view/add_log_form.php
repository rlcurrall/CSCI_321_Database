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
        <h1><?php echo $game['gameName']; ?></h1>
        <h2>Add Log Entry</h2>
        <form action="." method="post" id="log_form">
            <input type="hidden" name="action" value="add_log">
            <input type="hidden" name="game_id" value="<?php echo $gameID; ?>">
            
            <label>Date:</label>
            <input type='date' name='date'>
            <br>
            <br>
            
            <label>Description:</label>
            <textarea name="description" form="log_form" rows="4" cols="80"></textarea>
            <br>
            
            <label>&nbsp;</label>
            <input class="button" type="submit" value="Add Log Entry">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');