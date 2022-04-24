<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    
    //tokens
    $username = NULL;
    if(!empty($_SESSION['username'])) {
        $username=$_SESSION['username'];
    }

    //這段要放下面，不然 $result 會被上面的 token 相關蓋掉
    $result = $conn->query("SELECT * FROM cokecode_w9_comments ORDER BY ID DESC");
    if(!$result) {
        die('ERROR:' . $conn->error);
    }

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
                <?php } else { ?> <!--若已登入-->
                    <a class='board__btn' href="logout.php">登出</a>
                <?php } ?> <!--若已登入關-->
            </div>
          </div>

          <?php
            if(!empty($_GET['errCode'])) {
                $code = $_GET['errCode']; //檢查errCode帶的是啥
                $msg = 'Error';           // 預設錯誤訊息
                if ($code === '1') {
                    $msg = '錯誤:資料不齊全!';
                }
                echo'<div class="error__message">'. $msg . '</div>';
            }
          ?>
          
          <div class='board__greeting'>安安<?php echo $username?>想說啥呢 ?</div>
          <form class='board__form' method="POST" action="handle_add_comment.php">
              <div class ='broad__content'>
                  <textarea name ='content' row='5' placeholder ='請輸入您的留言...'></textarea>
                   <!-- 要記得幫 input '指定name' 不然程式會不知道要指向資料庫的哪個欄位-->
              </div>

              <?php if(!$username){ ?> <!--未登入-->
                <div class='board__greeting'>登入後一起加入討論吧 !</div>
              <?php }else { ?> <!--若已登入-->
                <input class='form__submit' type='submit' value='送出'> 
              <?php } ?> <!--若已登入關-->
          </form>
          <div class='broad__hr'></div>
          
          <?php
             while($row = $result->fetch_assoc()) {
          ?><!-- php while 開-->

          <section class='card'>
              <div class='card__avatar'></div>
              <div class='card__info'>
                  <span class='card__nickname'><?php echo $row['nickname']; ?></span>
                  <span class='card__createdAt'><?php echo $row['created_at']; ?></span>
                  <p class='card__content'><?php echo $row['content']; ?></p>
            </div>
          </section>
          <?php } ?><!-- php while 關 -->
          <!-- 
              注意!!開跟關的位置會決定新增的資料有誰，然後會新增到哪!!! -->
      </main>
  </body>
</html>