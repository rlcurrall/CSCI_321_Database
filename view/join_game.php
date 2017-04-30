<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $games = all_games();
    $total_games = count($games);
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
        <h1>Join Game</h1>
        <h4 style='margin-left: 5em; font-weight: 900;'>Add <?php echo $character['characterName']; ?> to a Game</h4>
        <table>
            <tr>
                <th>Game Name</th>
                <th>Description</th>
                <th>Dungeon Master</th>
                <th>&nbsp;</th>
            </tr>
            <?php 
            if ($total_games == 0) {
                ?>
            <tr>
                <td colspan="5">No Games</td>
            </tr>
            <?php
            }
            else {
            foreach ($games as $game) : ?>
            <tr>
                <td><?php echo $game['gameName']; ?></td>
                <td><?php echo $game['description']; ?></td>
                <td><?php echo $game['username']; ?></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="join_game">
                    <input type="hidden" name="game_id"
                           value="<?php echo $game['gameID']; ?>">
                    <input type='hidden' name='character_id'
                           value='<?php echo $character['characterID']; ?>'>
                    <input type="submit" class="button" value="Join">
                </form></td>
                
            </tr>
            <?php endforeach;
            }
            ?>
        </table>
        
        
    </main>
</div>

<?php
    include('view/footer.php');