<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $games = get_games($user['userID']);
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
        <h1>Games</h1>
        <table>
            <tr>
                <th>Game Name</th>
                <th>Description</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php 
            if ($games == NULL) {
                ?>
            <tr>
                <td colspan="5">No Games</td>
            </tr>
            <?php
            }
            else {
            foreach ($games as $game) : ?>
            <tr>
                <td style='text-align: center;'>
                    <form action='.' method='post' style='display: inline-block;'>
                        <input type='hidden' name='action'
                               value='game_page'>
                        <input type='hidden' name='game_id'
                               value='<?php echo $game['gameID']; ?>'>
                        <input class="gameLink" type="submit" value="<?php echo $game['gameName']; ?>">
                    </form>
                </td>
                <td><?php echo $game['description']; ?></td>
                
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="delete_game">
                    <input type="hidden" name="game_id"
                           value="<?php echo $game['gameID']; ?>">
                    <input type="submit" class="button" value="Delete">
                </form></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="edit_game_form">
                    <input type="hidden" name="game_id"
                           value="<?php echo $game['gameID']; ?>">
                    <input type="submit" class="button" value="Edit">
                </form></td>
                
            </tr>
            <?php endforeach;
            }
            ?>
            <tr>
                <td class="addChar" colspan="4" style="border: none;">
                    <form action="." method="post">
                        <input type="hidden" name="action" value="add_game_form">
                        <input type="hidden" name="user_id" value="<?php echo $user['userID'] ?>">
                        <input class="button" type="submit" value="Add game">
                    </form>
                </td>
            </tr>
        </table>
        
        
    </main>
</div>

<?php
    include('view/footer.php');