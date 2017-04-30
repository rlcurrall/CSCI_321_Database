<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        
        <form action="." method="post">
            <input type="hidden" name="action" value="view_characters">
            <input type="submit" class="aside_button" value="Characters">
        </form>
        <form action="." method="post">
            <input type="hidden" name="action" value="view_games">
            <input type="submit" class="aside_button" value="Games">
        </form>
    </aside>
    <main class="profile-main">
        <h1>Add Game</h1>
        <form action="." method="post" id="game_form">
            <input type="hidden" name="action" value="add_game">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            
            <label>Name:</label>
            <input type="text" name="name">
            <br>
            <br>
            
            <label>Description:</label>
            <textarea name="description" form="game_form" rows="4" cols="80"></textarea>
            <br>
            
            <label>&nbsp;</label>
            <input class="button" type="submit" value="Add Game">
        </form>
    </main>
</div>

<?php
    include('view/footer.php');