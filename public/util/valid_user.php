<?php

    if (!isset($_SESSION['is_valid_user']))
    {
        header("Location: .");
    } // end if
    
?>
