<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    require_once("utils_session.php");


    $content_id = NULL;
    if(!empty($_GET['contentid'])){
        $content_id = $_GET['contentid'];
    };

    //載入頁面資料
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
        <div class ='card__block__inpage'>
            <div class ='card__wapper'>
                <div class ='card__top'>
                    <span class ='card__title'><?php echo escape($row['title']); ?></span>
                    
                    <?php if(!empty($username)){ ?>
                        <div>
                            <a class ='card__btn' href ='update_content.php?contentid=<?php echo escape($content_id);?>'>編輯</a>
                            <a class ='card__btn' href ='handle_delete.php?contentid=<?php echo escape($content_id);?>'>刪除</a>
                        </div>
                    <?php } ?>

                </div>
                <div class ='card__info'>
                    <sapn class ='info__timestamp'><?php echo escape($row['created_at']); ?></span>
                    <span class ='info__type'>歷史公告</span>
                </div>
                <div class ='card__content__page'><?php echo escape($row['content']); ?></div>
                <div class ='card__bottom__inpage'></div>

                <div class ='page__bottom__info'>
                    <span class ='fullpage_btn'><a href='index.php'>回首頁</a></span>
                    <span class ='fullpage_btn'><a href='admin.php'>文章列表</a></span>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class ='footer__mes'>Copyright © 2020 Who's Blog All Rights Reserved.</div>
    </footer>
  </body>
</html>