<?php
    if ($characterID == NULL) {
        $characterID = $_GET['characterID'];
    }
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
        <h1 class="gamePageTitle"><?php echo $character['characterName'] ?></h1>
        <?php if ($character['userID'] == $_SESSION['userID']) { ?>
        <form action="." method="post" class="gameEditButton">
                <input type="hidden" name="action"
                       value="edit_character_form">
                <input type="hidden" name="page" value="TRUE">
                <input type="hidden" name="character_id"
                       value="<?php echo $character['characterID']; ?>">
                <input type="submit" class="button" value="Edit">
            </form>
        <?php } ?>
        <div class="gameDescription">
            <h4 style="clear: both;">Game:</h4>
            <p style="margin: 0; float: left; margin: 0.9em 1em;">
                <?php 
                    if ($character['gameID'] == NULL) {
                        ?>No Game<?php
                    }
                    else { ?>
                        <a href="index.php?action=game_page&gameID=<?php echo $character['gameID']; ?>"
                           class="gameLink"><?php echo $character['gameName']; ?> </a>
                        <?php
                    }
                ?>&nbsp;
            </p>
            <?php
                if ($character['gameID'] != NULL && $character['userID'] === $_SESSION['userID']) {
            ?>
            <form style="float: left;" action="." method="post">
                <input type="hidden" name="character_id" value="<?php echo $character['characterID']; ?>">
                <input type="hidden" name="action" value="leave_game">
                <input type="submit" value="Leave Game" class="button">
            </form>
            <?php }
            else if ( $character['userID'] === $_SESSION['userID']) {
                ?>
                    <form style="float: left;" action="." method="post">
                        <input type="hidden" name="action" value="join_game_form">
                        <input type="hidden" name="character_id"
                               value="<?php echo $character['characterID']; ?>">
                        <input type="hidden" name="page" value="TRUE">
                        <input type="submit" value="Join Game" class="button">
                    </form>
                <?php
            }
            ?>
        </div>
        <div class="gameDescription">
            <h3>Background</h3>
            <p><?php echo $character['background']; ?></p>
        </div>
        <div class="gameLog">
            <p>The answer is: <?php
            $testname = 'hello';
            $test = is_username_free($testname); 
            echo $test; ?></p>
            <p>
                <?php 
                    $date = "2010-03-21";
                    echo $date; ?>
            </p>
            <p>
                    <?php
                    $newDate = date("d/m/y", strtotime($date));
                    echo $newDate;
                ?>
            </p>
            <p>
                <?php
                $otherDate = date("d-m-y", strtotime($newDate));
                echo $otherDate;
                ?>
            </p>
        </div>
    </main>
</div>

<?php
    include('view/footer.php');