<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    require_once("utils_session.php");
    
    
    /* 頁數相關設定 */ 
    $page = 1;
    if(!empty($_GET['page'])){
        $page = $_GET['page'];
    }

    $item_per_page = 5;
    $offset = ($page - 1) * $item_per_page;
    

    /* 拿資料 */ 
    $sql ="SELECT * FROM cokecode_w11_blog WHERE is_deleted IS NULL ORDER BY id DESC limit ? offset ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $item_per_page, $offset);
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

    <section class ='cards'>
        <!-- php while 開--><?php while($row = $result->fetch_assoc()) { ?>
        
            <div class ='card__block'>
                <!--帶上文章id --><?php $content_id = $row['id'];?>
                <div class ='card__wapper'>
                    <div class ='card__top'>
                        <span class ='card__title'><?php echo escape($row['title']); ?></span>
                        <?php if(!empty($username)){ ?>
                            <a class ='card__btn' href ='update_content.php?contentid=<?php echo $row['id']; ?>'>編輯</a>
                        <?php } ?>
                    </div>
                    <div class ='card__info'>
                        <sapn class ='info__timestamp'><?php echo escape($row['created_at']); ?></span>
                        <span class ='info__type'>歷史公告</span>
                    </div>
                    <div class ='card__content__index'><?php echo escape($row['content']); ?></div>
                    <a class ='readmore__btn' href='full_page.php?contentid=<?php echo escape($row['id']); ?>'>READ MORE</a>
                </div>
            </div>

        <!-- php while 關--><?php } ?>


        <!-- 頁數相關-->
        <?php
            $sql ="SELECT count(id) as count FROM cokecode_w11_blog WHERE is_deleted IS NULL";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];

            $total_page = ceil($count / $item_per_page);
        ?>

        <div class ='pages'>
            <span>目前總共有 <?php echo $count; ?> 篇文章，</span>
            <span>頁數<?php echo $page; ?> / <?php echo $total_page; ?></span>
            <div class='page__pointer'>
                <?php if($page != 1) { ?>
                    <a href='index.php?page=<?php echo 1; ?>'>首頁</a>
                    <a href='index.php?page=<?php echo ($page - 1); ?>'>上一頁</a>
                <?php } ?>
                <?php if($page != $total_page) { ?>
                    <a href='index.php?page=<?php echo ($page + 1); ?>'>下一頁</a>
                    <a href='index.php?page=<?php echo $total_page; ?>'>最末頁</a>
                <?php } ?>
            </div>
        </div>

    </section>




    <footer>
        <div class ='footer__mes'>Copyright © 2020 Who's Blog All Rights Reserved.</div>
    </footer>
  </body>
</html>