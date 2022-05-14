<?php
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        header('Location:login.php?errCode=1');
        die();
    }

    $sql = "SELECT * FROM cokecode_w11_user WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();
    if(!$result){
        die($conn->error);
    }

    //找不到使用者
    $result = $stmt->get_result();
    if($result->num_rows === 0){
        header('Location:login.php?errCode=2');
        die();
    }

    $row = $result->fetch_assoc();
    if(password_verify($password, $row['password'])){
        $_SESSION['username'] = $username; //存 username 在 session (自動登入ㄉ意思)
        header('Location:index.php');
    }else {
        header('Location:login.php?errCode=3');
    }

?>