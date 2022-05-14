<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    
    $id = $_GET['contentid'];
    
    $sql ="UPDATE cokecode_w11_blog SET is_deleted=1 WHERE id =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    header('Location:admin.php');
?>
