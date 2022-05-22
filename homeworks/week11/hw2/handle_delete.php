<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");
    require_once("utils_session.php");


    // 檢查是否為作者
    $row = getUserFromUsername($username);
    if($row['username']!== $username || $username === NULL){
        header('location:index.php?errCode=3');
        die('權限不足');
    }

    // 刪除相關
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
