<?php
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    if(
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        header('Location: login.php?errCode=1');
        die();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = sprintf(
        "select * from cokecode_w9_users where username='%s'and password='%s'",//記得裡面外面單雙引號不要重複
        $username,
        $password
    );

    $result = $conn->query($sql);
    if(!$result) {
        die($conn->error);
    }

    
    if($result->num_rows) {
        // 登入成功的話
        $_SESSION['username'] = $username; //把 username 存在 session 裡面
        header('Location: index.php');
    }else { // 資料庫裏面沒有符合的資料的話
        header('Location: login.php?errCode=2');
    }
 
?>

