<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    //檢查資料是否為空
    if (
        empty($_POST['content'])
    ) {
        header('Location: index.php?errCode=1');
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
    if(checkCreat($row_status, $row, $username) === true){
        $content = $_POST['content'];
        $sql = "INSERT INTO cokecode_w9_comments(username, content) VALUES(?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',$username, $content);
        $result = $stmt->execute();
        if(!$result) {
            die($conn->error);
        }
        header("Location: index.php");
        die();
    }else {// 沒有權限
        header("Location: index.php?errCode=21");
        die();
    }
?>
