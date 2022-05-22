
<nav class ='navbar'>
    <div class ='nav__left'>
        <span><a class ='nav__web-title' href ='index.php'>Who's Blog</span>
        <?php if(empty($_SESSION['username'])){ ?>
            <a class ='nav__btn' href ='admin.php'>文章列表</a>
        <?php } ?>
        <a class ='nav__btn' href='#'>分類專區(尚未開放)</a>
        <a class ='nav__btn' href='#'>關於我(尚未開放)</a>
    </div>
    <div class ='nav__right'>
        <?php if(!empty($_SESSION['username'])){ ?>
            <a class ='nav__btn' href ='admin.php'>管理後臺</a>
            <a class ='nav__btn' href ='add_content.php'>新增文章</a>
            <a class ='nav__btn' href='handle_logout.php'>登出</a>
        <?php }else{ ?>
            <a class ='nav__btn' href='login.php'>登入</a>
        <?php } ?>


    </div>
</nav>
