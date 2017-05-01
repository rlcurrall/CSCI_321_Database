<?php
    // probably dangerous to have because it allows form resubmission
    header('Cache-Control: no chache');
    
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $games = all_games();
    $total_games = count($games);
    
    if ($characterID != NULL){
        $_SESSION['joinCharacter'] = $characterID;
    }
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <a class="aside_button" href="index.php?action=view_characters">Characters</a>
        <a class="aside_button" href="index.php?action=view_games">Games</a>
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
                <td>
                    <form action='.' method='post' style='display: inline-block;'>
                        <input type='hidden' name='action'
                               value='game_page'>
                        <input type='hidden' name='game_id'
                               value='<?php echo $game['gameID']; ?>'>
                        <input class="gameLink" type="submit" value="<?php echo $game['gameName']; ?>">
                    </form>
                    <!--<?php echo $game['gameName']; ?>-->
                </td>
                <td><?php echo $game['description']; ?></td>
                <td><?php echo $game['username']; ?></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="join_game">
                    <input type="hidden" name="game_id"
                           value="<?php echo $game['gameID']; ?>">
                    <input type='hidden' name='character_id'
                           value='<?php echo $_SESSION['joinCharacter']; ?>'>
                    <input type="hidden" name="page" value="<?php echo $charPage; ?>">
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