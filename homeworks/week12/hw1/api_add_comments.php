<?php
    require_once("conn.php");
    header('Content-type:application/json;charset=utf-8'); // 要加這個 tag 才能讓資料變 json 格式
    header('Access-Control-Allow-Origin: *'); // 讓跨網域可以存取 CORS
    if(
        empty($_POST['content']) ||
        empty($_POST['nickname']) ||
        empty($_POST['site_key'])
    ){
        $json = array(
            "ok" => false,
            "message" =>"Please input missing fields."
        );

        $response = json_encode($json);
        echo $response;
        die();
    }


    $site_key = $_POST['site_key'];
    $nickname = $_POST['nickname'];
    $content = $_POST['content'];

    $sql = 'INSERT INTO cokecode_w12_discussions(site_key, nickname, content) VALUE(?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $site_key, $nickname, $content);
    $result = $stmt->execute();

    if(!$result){
        $json = array(
            "ok" => false,
            "message" =>$conn->error
        );
        $response = json_encode($json);
        echo $response;
        die();
    }

    $json = array(
        "ok" => true,
        "message" =>"seccess"
    );

    $response = json_encode($json);
    echo $response;

?>

