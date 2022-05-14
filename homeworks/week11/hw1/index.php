<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    
    //登入相關
    $username = NULL;
    $row_status = NULL;
    if(!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];

        //抓身分資料
        $row = getUserFromUsername($username);
        $row_status = getUserStatus($username);
    }


    /*  頁面相關 開始 */
    $page = 1;
    if(!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    $item_per_page = 5;
    $offset = ($page - 1) * $item_per_page;

    //抓頁面資料
    $stmt = $conn->prepare(
        "SELECT c.ID as id, u.nickname as nickname, c.content as content, c.created_at as created_at, u.username as username FROM cokecode_w9_comments as c ".
        "LEFT JOIN cokecode_w9_users as u on c.username = u.username ".
        "WHERE c.is_deleted IS NULL ".    // SQL 特殊語法! 一定要寫 IS NULL 不可以寫成 =NULL !!!
        "ORDER BY c.ID DESC ".
        "limit ? offset ?"
    );
    $stmt->bind_param('ii', $item_per_page, $offset);
    $result = $stmt->execute();
    if(!$result) {
        die('ERROR:' . $conn->error);
    }

    $result = $stmt->get_result();
    /*  頁面相關 結束  */

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>阿摟哈留言板</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
      <header class='warning'>
          <strong>注意!本網站為練習用網站，因教學用途刻意忽略資安的操作，註冊時請勿使用任何真實的帳號或密碼。</strong>
      </header>
      <main class='board'>
            <div class='board__top'>
                <h1 class='board__title'>阿摟哈留言板</h1>
                <div class='board__btns'>
                    <?php if(!$username){ ?><!--未登入-->
                        <a class='board__btn' href="register.php">註冊</a>
                        <a class='board__btn' href="login.php">登入</a>
                    <?php } else { ?><!--若已登入-->
                        <a class='board__btn' href="logout.php">登出</a>
                            <?php if($row['role']==='admin'){ ?><!--若為管理員 開-->
                                <a class='board__btn' href="edit_user_status.php">管理後台</a>
                            <?php } ?><!--若為管理員 關-->
                        <input class='form__submit nickname__update__btn' type='submit' value='更改暱稱'>
                    <?php } ?> <!--若已登入關-->


                </div>
            </div>

            <!-- 更動 nickname -->
            <form class='hide update__nickname' method='POST' action='handle_update_nickname.php'>
                <div class='form__block'>
                    <span class ='form__block__title'>新暱稱:</span>
                    <input name='nickname' class ='form__block__input' type="text" placeholder ='想取甚麼新暱稱呢?' />
                </div>
                <input class='form__submit' type='submit' value='更改'/>
                <div class='broad__hr'></div>
            </form>
            

            <!-- 檢查 errCode -->
            <!-- 
                errCode 
                        21:新增 權限不足
                        31:編輯 權限不足
                        41:刪除 權限不足
            -->
            <?php
                if(!empty($_GET['errCode'])) {
                    $msg = 'Error'; // 預設錯誤訊息
                    
                    switch($_GET['errCode']){
                        case '1':
                            $msg ='錯誤:資料不齊全!';
                            break;
                        case '21':
                            $msg ='錯誤:新增 權限不足!';
                            break;
                        case '31':
                            $msg ='錯誤:編輯 權限不足!';
                            break;
                        case '41':
                            $msg ='錯誤:刪除 權限不足!';
                            break;
                    }
                    echo'<div class="error__message">'. $msg . '</div>';
                }
            ?>
          
            <div class='board__greeting'>安安<?php echo escape($username);?>想說啥呢 ?</div>
            <form class='board__form add__comment' method="POST" action="handle_add_comment.php">
                <div class ='broad__content'>
                    <textarea name ='content' row='5' placeholder ='請輸入您的留言...'></textarea>
                    <!-- 要記得幫 input '指定name' 不然程式會不知道要指向資料庫的哪個欄位-->
                </div>

                <?php if(!$username){ ?> <!--未登入-->
                    <div class='board__greeting'>登入後一起加入討論吧 !</div>
                <?php }else if($row['role']==='banned'){ ?> <!--若已登入-->
                    <div class='board__greeting'>你已被水桶~請洽管理員</div>
                <?php }else if(checkCreat($row_status, $row, $username)){ ?> <!--若已登入-->
                    <input class='form__submit' type='submit' value='送出'> 
                <?php } ?> <!--若已登入關-->
            </form>
            <div class='broad__hr'></div>
            
            <!-- php while 開-->
            <?php while($row = $result->fetch_assoc()) { ?>
                <section class='card'>
                    <div class='card__avatar'></div>
                    <div class='card__info'>
                        <span class='card__nickname'><?php echo escape($row['nickname']); ?></span>
                        <span class='card__createdAt'><?php echo escape($row['created_at']); ?></span>
                            <!-- php 判斷編輯權限 開 -->
                            <?php if(!empty($username)){ //這樣沒登入時，才不會在 Utils 載入後面那段空的變數(會報錯:trying to access array offset on value of type null)(resource:http://jianyuluntan.com/post/158.html)
                                    if(checkUpdateOthers($row_status, $row, $username)||checkUpdateSelf($row_status, $row, $username)) { ?>
                                    <a href="update_content.php?id=<?php echo $row['id'];?>">編輯</a>
                            <?php }} ?><!-- 判斷編輯權限 關 -->
                            
                            <!-- php 判斷刪除權限 開 -->
                            <?php if(!empty($username)){
                                if(checkDeleteOthers($row_status, $row, $username)||checkDeleteSelf($row_status, $row, $username)) { ?>
                                <a href="handle_delete_content.php?id=<?php echo $row['id'];?>">刪除</a>
                            <?php }} ?><!-- php 判斷刪除權限 關 -->
                        <p class='card__content'><?php echo escape($row['content']); ?></p>
                    </div>
                </section>
            <?php } ?>
            <!-- php while 關 -->

            
            
            
            <!-- 頁數相關 php -->
            <?php 
                $stmt = $conn->prepare(
                    "SELECT count(id) as count FROM cokecode_w9_comments WHERE is_deleted IS NULL"
                );
                $result = $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $count = $row['count'];

                $total_page = ceil($count / $item_per_page);
            ?>

            <div class='broad__hr'></div>
            <div class ='page__info'>
                <span>目前總共有 <?php echo $count; ?> 筆留言，頁數</span>
                <span><?php echo $page; ?> / <?php echo $total_page; ?></span>
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
      </main>

      <!-- 修改暱稱相關 script -->
      <?php if($username){ ?>
            <script>
                var btn = document.querySelector('.nickname__update__btn')
                btn.addEventListener('click', function(){
                    var form = document.querySelector('.update__nickname')
                    form.classList.toggle('hide')
                })
            </script>
       <?php } ?>
  </body>
</html>