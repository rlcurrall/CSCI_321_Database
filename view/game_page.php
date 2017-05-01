<?php
    if ($gameID == NULL) {
        //$gameID = $_GET['gameID'];
        $gameID = filter_input(INPUT_GET, 'gameID');
    }
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $players = get_players($gameID);
    $game = get_game($gameID);
    $logs = get_logs($gameID);
?>
<div class="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <a class="aside_button" href="index.php?action=view_characters">Characters</a>
        <a class="aside_button" href="index.php?action=view_games">Games</a>
    </aside>
    <main class="profile-main">
        <h1 class="gamePageTitle"><?php echo $game['gameName'] ?></h1>
        <?php if ($game['adminID'] == $_SESSION['userID']) { ?>
        <form action="." method="post" class="gameEditButton">
                <input type="hidden" name="action"
                       value="edit_game_form">
                <input type="hidden" name="page" value="TRUE">
                <input type="hidden" name="game_id"
                       value="<?php echo $game['gameID']; ?>">
                <input type="submit" class="button" value="Edit">
            </form>
        <?php } ?>
        <div class="gameDescription">
            <h3>Description</h3>
            <p><?php echo $game['description']; ?></p>
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
                    <td>
                        <a href="index.php?action=character_page&characterID=<?php echo $player['characterID']; ?>"
                       class="gameLink">
                        <?php echo $player['characterName']; ?>
                    </a>
                    </td>
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
            <h3>Game Log</h3>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Session Summary</th>
                    <?php if ($logs != NULL) { 
                        if ($game['adminID'] === $_SESSION['userID']) { ?>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <?php } } ?>
                </tr>
                <?php if ($logs != NULL) {
                foreach($logs as $log) : ?>
                <tr>
                    <td><?php 
                    $date = date('m/d/y', strtotime($log['date']));
                    echo $date; ?></td>
                    <td><?php echo $log['description']; ?></td>
                    <?php if ($game['adminID'] === $_SESSION['userID']) { ?>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action"
                                value="delete_log">
                            <input type="hidden" name="log_id"
                                value="<?php echo $log['logID']; ?>">
                            <input type="hidden" name="game_id"
                                   value="<?php echo $gameID ?>">
                            <input type="submit" class="button" value="Delete">
                        </form>
                    </td>
                    <td>
                        <form action="." method="post">
                            <input type="hidden" name="action"
                                value="edit_log_form">
                            <input type="hidden" name="log_id"
                                value="<?php echo $log['logID']; ?>">
                            <input type="hidden" name="game_id"
                                   value="<?php echo $gameID ?>">
                            <input type="submit" class="button" value="Edit">
                        </form>
                    </td>
                    <?php } ?>
                </tr>
                <?php endforeach; 
                }
                else {
                    ?><tr><td colspan="5">No Log Entries</td></tr><?php
                }
?>
                <?php if ($game['adminID'] === $_SESSION['userID']) { ?>
                <tr>
                    <td colspan="2" style="border: none;">
                        <form action="." method='post'>
                            <input type='hidden' name='action' value='add_log_form'>
                            <input type='hidden' name='game_id' value='<?php echo $gameID; ?>'>
                            <input type='submit' class="button" value='Add Log'>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</div>

<?php
    include('view/footer.php');