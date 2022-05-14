<?php
    session_start();
    require_once('conn.php');
    require_once("utils.php");
    require_once("utils_session.php");

    //檢查輸入是否為空
    if(
        empty($_POST['title'])||
        empty($_POST['content'])
    ) {
        header('location:update_content.php?errCode=1&contentid='. $_POST['contentid']);
        die('資料不齊全');
    }


    $id = $_POST['contentid'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    //上傳資料
    $sql ="UPDATE cokecode_w11_blog SET title=?, content=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi',$title ,$content, $id);
    $result = $stmt->execute();
    if(!$result) {
        die($conn->error);
    }

    header('Location:full_page.php?contentid='. $id);
?>
