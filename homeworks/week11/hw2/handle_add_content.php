<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");


    //檢查是否輸入為空
    if(
        empty($_POST['title'])||
        empty($_POST['content'])
    ) {
        header('location:add_content.php?errCode=1');
        die('資料不齊全');
    }

    //作業區塊
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql ="INSERT INTO cokecode_w11_blog(title, content) VALUE (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss',$title ,$content);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    header('Location:index.php');

?>
