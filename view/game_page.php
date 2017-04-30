<?php
    if ($gameID == NULL) {
        $gameID = $_GET['gameID'];
    }
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $players = get_players($gameID);
    $game = get_game($gameID);
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
        <h1 class="gamePageTitle"><?php echo $game['gameName'] ?></h1>
        <form action="." method="post" class="gameEditButton">
                <input type="hidden" name="action"
                       value="edit_game_form">
                <input type="hidden" name="page" value="TRUE">
                <input type="hidden" name="game_id"
                       value="<?php echo $game['gameID']; ?>">
                <input type="submit" class="button" value="Edit">
            </form>
        <div class="gameDescription">
            <h3>Description</h3>
            <p><?php echo $game['description']; ?></p>
            <!--
            <form action="." method="post">
                <input type="hidden" name="action"
                       value="edit_game_form">
                <input type="hidden" name="game_id"
                       value="<?php echo $game['gameID']; ?>">
                <input type="submit" class="button" value="Edit">
            </form>
            -->
        </div>
        <div class="players">
            <h3>Players</h3>
            <table>
                <tr>
                    <th>Character Name</th>
                    <th>User</th>
                    <?php if ($game['adminID'] === $_SESSION['userID']) { ?>
                    <th>&nbsp;</th>
                    <?php } ?>
                </tr>
                <?php 
                if ($players == NULL) {
                    ?>
                <tr>
                    <td colspan="4">No Players</td>
                </tr>
                <?php
                }
                else {
                foreach ($players as $player) : ?>
                <tr>
                    <td><?php echo $player['characterName']; ?></td>
                    <td><?php echo $player['username']; ?></td>
                
                    
                    <?php if ($game['adminID'] === $_SESSION['userID']) { ?>
                    <td><form action="." method="post">
                        <input type="hidden" name="action"
                               value="remove_from_game">
                        <input type="hidden" name="game_id"
                               value="<?php echo $game['gameID']; ?>">
                        <input type="hidden" name="character_id"
                               value="<?php echo $player['characterID'] ?>">
                        <input type="submit" class="button" value="Remove">
                    </form></td>
                    <?php } ?>
                </tr>
                <?php endforeach;
                }
                ?>
            </table>
        </div>
        <div class="gameLog">
            <p>The answer is: <?php
            $testname = 'hello';
            $test = is_username_free($testname); 
            echo $test; ?></p>
        </div>
    </main>
</div>

<?php
    include('view/footer.php');