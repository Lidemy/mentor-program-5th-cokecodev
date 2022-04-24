<?php
    session_start();
    session_destroy();//清除session
    header('Location: index.php');
?>

