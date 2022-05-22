<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    // 檢查是否登入
    if(!$_SESSION['username']) {
        header('Location:login.php');
        die('請登入!');
    }

    
    // 準備檢查是否有權限
    $username = $_SESSION['username'];
    $row = getUserFromUsername($username);
    if($row['role'] !== 'admin'){
        header('Location:index.php');
        die('沒有權限');
    }



    //拿資料嚕
    $id = $_GET['ID'];
    $changeInto = $_GET['role'];
    $sql = "UPDATE cokecode_w9_users SET role=? WHERE ID=?";
    $stmt= $conn->prepare($sql);
    $stmt->bind_param('si',$changeInto ,$id);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    header("Location:edit_user_status.php");
?>
