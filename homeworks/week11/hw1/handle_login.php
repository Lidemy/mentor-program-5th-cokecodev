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

    //先撈 username，再把密碼撈出來比對
    $sql = "select * from cokecode_w9_users where username=?";
    $stmt =$conn->prepare($sql);
    $stmt->bind_param('s',$username);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    //抓不到東西的話
    $result = $stmt->get_result();  //注意!!!要多加這行下面才撈得到東西。
    if($result->num_rows === 0) {
        header('Location:longin.php?errCode=2');
        exit();
    }

    $row = $result->fetch_assoc();
    if(password_verify($password,$row['password'])){
        // 登入成功的話
        $_SESSION['username'] = $username; //把 username 存在 session 裡面
        header('Location: index.php');
    }else { // 資料庫裏面沒有符合的資料的話
        header('Location: login.php?errCode=2');
    }
 
?>

