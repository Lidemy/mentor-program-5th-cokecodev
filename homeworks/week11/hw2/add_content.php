<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    require_once("utils_session.php");

    

    /* 拿資料 */ 
    $sql ="SELECT * FROM cokecode_w11_blog WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $content_id);
    $result = $stmt->execute();
    if(!$result){
        die('ERROR:' . $conn->error);
    }
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>


<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>存放技術之地</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <?php
        require_once('section_nav.php');
        require_once('section_banner.php');
    ?>

    <section class ='cards'>
        <div class ='update__card'>
            <form class ='update__form' method="POST" action ='handle_add_content.php'>
                <div class ='update__title'>新增文章</div>
                <div class ='update__content-title'>
                    <input name ='title' type ='text' placeholder='請輸入文章標題'/>
                </div>
                <div class ='update__content'>
                    <textarea name ='content'></textarea>
                </div>
                <input class ='update__btn' type ='submit' value='送出文章'placeholder='請輸入內容'/>

                <!-- 檢查&錯誤訊息 -->
                <?php
                    if(!empty($_GET['errCode'])) {
                        $code = $_GET['errCode'];
                        $msg = 'ERROR';
                        if($code === '1') {
                            $msg = '資料不齊全辣!';
                        }
                        echo'<span class="error__message">' . $msg . '</span>';
                    }
                ?>

            </form>
        </div>
    </section>


    <footer>
        <div class ='footer__mes'>Copyright © 2020 Who's Blog All Rights Reserved.</div>
    </footer>
  </body>
</html>