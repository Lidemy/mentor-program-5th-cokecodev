<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");

    if (
        empty($_POST['content'])
    ) {
        header('Location:index.php?errCode=1&id='.$_POST['id']);
        die('資料不齊全');
    }


    
    $username = $_SESSION['username'];
    $id = $_POST['id']; //要偷偷自己帶進來，不然上頁的GET傳不進來
    $content = $_POST['content'];


    $sql = "UPDATE cokecode_w9_comments SET content=? where ID=?";
    $stmt= $conn->prepare($sql);
    $stmt->bind_param('si',$content ,$id);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    header("Location: index.php");
?>
