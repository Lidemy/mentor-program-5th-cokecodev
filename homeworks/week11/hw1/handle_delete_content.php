<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    //檢查資料是否齊全
    if (
        empty($_GET['id'])
    ) {
        header('Location:index.php?errCode=1&id='.$_POST['id']);
        die('資料不齊全');
    }


    // 檢查是否登入
    if(!$_SESSION['username']) {
        header('Location:login.php');
        die('請登入!');
    }

    // 準備檢查是否有權限
    $username = $_SESSION['username'];
    $row = getUserFromUsername($username);
    $row_status = getUserStatus($username);
    
    // 有權限
    if(checkDeleteOthers($row_status, $row, $username) === true || checkDeleteSelf($row_status, $row, $username) === true){
        $id = $_GET['id'];

        $sql = "UPDATE cokecode_w9_comments SET is_deleted=1 WHERE ID=?";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        if(!$result) {
            die($conn->error);
        }
        header("Location: index.php");
        die();
    }else { // 沒有權限
        header("Location: index.php?errCode=41");
        die();
    }

?>
