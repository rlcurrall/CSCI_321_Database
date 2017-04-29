<?php
    include('view/header.php');
    $user = get_user($_SESSION['username']);
    $characters = get_characters($user['userID']);
?>
<div id="profile-body">
    <aside>
        <h2><?php echo $user['name']; ?></h2>
        <form action="." method="post">
            <input type="hidden" name="action" value="view_characters">
            <input type="submit" id="aside_button" value="Characters">
        </form>
        <form action="." method="post">
            <input type="hidden" name="action" value="view_games">
            <input type="submit" id="aside_button" value="Games">
        </form>
    </aside>
    <main id="profile-main">
        <h1>Characters</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Background</th>
                <th>Game</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php 
            if ($characters == NULL) {
                ?>
            <tr>
                <td colspan="5">No Characters</td>
            </tr>
            <?php
            }
            else {
            foreach ($characters as $character) : ?>
            <tr>
                <td><?php echo $character['characterName']; ?></td>
                <td><?php echo $character['background']; ?></td>
                <td ><?php 
                    if ($character['gameName'] === NULL) {
                        ?>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="join_game_form">
                        <input type="hidden" name="character_id"
                               value="<?php echo $character['characterID']; ?>">
                        <input type="submit" value="Join Game" id="button">
                    </form>
                    <?php
                    }
                    else {
                        echo $character['gameName'];
                    }?></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="delete_character">
                    <input type="hidden" name="character_id"
                           value="<?php echo $character['characterID']; ?>">
                    <input type="submit" id="button" value="Delete">
                </form></td>
                <td><form action="." method="post">
                    <input type="hidden" name="action"
                           value="edit_character_form">
                    <input type="hidden" name="character_id"
                           value="<?php echo $character['characterID']; ?>">
                    <input type="submit" id="button" value="Edit">
                </form></td>
            </tr>
            <?php endforeach;
            }
            ?>
            <tr>
                <td id="addChar" colspan="4" style="border: none;">
                    <form action="." method="post">
                        <input type="hidden" name="action" value="add_character_form">
                        <input type="hidden" name="user_id" value="<?php echo $user['userID'] ?>">
                        <input id="button" type="submit" value="Add Character">
                    </form>
                </td>
            </tr>
        </table>
        
        
    </main>
</div>

<?php
    include('view/footer.php');