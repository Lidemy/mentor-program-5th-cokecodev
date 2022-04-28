<?php
    require_once('conn.php');

    if(
        empty($_POST['nickname']) ||
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        header('Location: register.php?errCode=1');
        die();
    }

    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = sprintf(
        "INSERT INTO cokecode_w9_users(nickname, username, password) VALUES('%s','%s','%s')",
        $nickname,
        $username,
        $password
    );

    
    
    $result = $conn->query($sql);
    if(!$result) {
       $code = $conn->errno;
       if ($code === 1062){
        header("Location: register.php?errCode=2");
       }
       die($conn->error);
       

        /*
        if(strpos($conn->errno,'Duplicate entry') !== false){
            header("Location:register.php?errCode=2");
            // 錯誤訊息: Fatal error: Uncaught mysqli_sql_exception: Duplicate entry '輸入值' for key 'key名字' in.....
        */
        }
        
    
 
    header("Location: index.php");
    
?>

