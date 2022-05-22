<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");
    

    // 檢查是否登入
    if(!$_SESSION['username']) {
        header('Location:login.php');
        die('請登入!');
    }

    // 準備檢查是否有權限
    $username = $_SESSION['username'];
    $row = getUserFromUsername($username);
    $row_status = getUserStatus($username);


    // 有權限
    if(checkUpdateOthers($row_status, $row, $username) === true || checkUpdateSelf($row_status, $row, $username) === true){
        // 跟文章相關的
        $id = $_GET['id']; /* 一開始不小心寫成POST QQ 放在網址是GET!!! 不要忘記!!!*/

        //抓資料
        $sql = "SELECT content FROM cokecode_w9_comments WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $result = $stmt->execute(); //看 $conn 有沒有成功
        if(!$result) {
            die('ERROR:' . $conn->error);
        }

        // 拿出真的 result 值
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }else { // 沒有權限
        header('Location:index.php?errCode=31');
        die('尼~權限不足~');
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
                <h1 class='board__title'>編輯留言</h1>
            </div>
            <form class='board__form add__comment' method="POST" action="handle_update_content.php">
                <div class ='broad__content'>
                    <textarea name ='content' row='5'><?php  echo $row['content']; ?></textarea>
                    <input class='hide' name ='id' type =text value ='<?php echo $_GET['id']; ?>'>
                </div>
                <input class='form__submit' type='submit' value='送出'> 
            </form>
      </main>

  </body>
</html>