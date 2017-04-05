<?php
    include('view/header.php');
?>
<body>
    <p><?php echo $_SESSION['is_valid_login']; ?></p>
    <p><?php echo $username; ?></p>
    <p><?php echo $password; ?></p>
    <br>
    
    <table >
        
    </table>
    
    <form action="." method="post">
        <input type="hidden" name="action" value="logout">
        <input type ="submit" value ="Logout">
    </form>
</body>

<?php
    include('view/footer.php');