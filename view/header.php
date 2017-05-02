<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Eagle+Lake" rel="stylesheet">
	<meta name="viewport" content="width=device-width,minimum-scale=1">
        <link rel="shortcut icon" href="images/scroll_lock_32.png" >
        <title>Scroll Lock</title>
        <link href="style/main.css" rel="stylesheet">
        <script type="text/javascript" src="js/drop-down.js"></script>
    </head>
    <body>
        <header>
            <a class="home-link" href="index.php">
                <img class="logo" src="images/scroll_lock.png" 
                     onclick="document.write('<?php $action = "view_characters"; ?>');">
            </a>
            <h1 class="title">Scroll Lock</h1>
            <div class="ham_menu">
                <input type="image" src="images/menu-icon.png" id="dropDown" 
                       class="dropbtn" onclick="dropDown()">
                
                <div id="myDropdown" class="dropdown-content">
                    <p style="margin: 0; padding: 0; width: 8em; text-align: center; font-size: 1em;" class="logout"><a href="index.php?action=profile" class="logout">Profile</a></p>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="logout">
                        <input style="box-shadow: none; border: none; font-size: 1em;" class="logout" type ="submit" value ="Logout">
                    </form>
                </div>
            </div>
            <!--
            
            *** could not implement in time ***
            
            <form class="search" action="." method="post">
                <input type="hidden" name="action" value="search">
                <input type="text" name="keyword" required class="search_field">
                <input type="image" src="images/search.png" class="search_icon" >
            </form>
            -->
        </header>