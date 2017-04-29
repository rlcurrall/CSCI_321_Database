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
            <a id="home-link" href="index.php">
                <img id="logo" src="images/scroll_lock.png" 
                     onclick="document.write('<?php $action = "view_characters"; ?>');">
            </a>
            <h1 id="title">Scroll Lock</h1>
            <div id="ham_menu">
                <input type="image" src="images/menu-icon.png" id="dropDown" 
                       class="dropbtn" onclick="dropDown()">
                
                <div id="myDropdown" class="dropdown-content">
                    <form action="." method="post">
                        <input type="hidden" name="action" value="logout">
                        <input id="logout" type ="submit" value ="Logout">
                    </form>
                </div>
            </div>
            <form id="search" action="." method="post">
                <input type="hidden" name="action" value="search">
                <input type="text" name="keyword" required id="search_field">
                <input type="image" src="images/search.png" id="search_icon" >
            </form>
        </header>