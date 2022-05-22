<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    require_once("utils_session.php");

    $sql ="SELECT * FROM cokecode_w11_blog WHERE is_deleted IS NULL ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    /*$stmt->bind_param('s', $content_id);*/
    $result = $stmt->execute();
    if(!$result){
        die('ERROR:' . $conn->error);
    }
    
    $result = $stmt->get_result();
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

    <section class ='main'>
        <div class ='card__admin'>
        <?php while($row = $result->fetch_assoc()) { ?>
        <!-- php while 開-->

            <div class ='admin__block'>
                <!-- 帶上文章 id --><?php $content_id = $row['id'];?>
                <div class ='admin__page'>
                    <a class ='card__title admin__page__title' href ='full_page.php?contentid=<?php echo $content_id;?>'><?php echo escape($row['title']); ?></a>
                    <div class ='admin__info'>
                        <sapn class ='info__timestamp'><?php echo escape($row['created_at']); ?></span>
                        <?php if(!empty($username)){ ?>
                            <a class ='card__btn admin__time' href ='update_content.php?contentid=<?php echo escape( $row['id']); ?>'>編輯</a>
                            <a class ='card__btn' href ='handle_delete.php?contentid=<?php echo escape( $row['id']); ?>'>刪除</a>
                        <?php } ?>
                    </div>
                </div>
                <div class='broad__hr'></div>
            </div>

        <?php } ?>
        <!-- php while 關-->
        </div>
    </section>

    <footer>
        <div class ='footer__mes'>Copyright © 2020 Who's Blog All Rights Reserved.</div>
    </footer>
  </body>
</html>