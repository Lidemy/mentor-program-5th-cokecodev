<?php
    require_once("conn.php");
    header('Content-type:application/json;charset=utf-8'); // 要加這個 tag 才能讓資料變 json 格式
    header('Access-Control-Allow-Origin: *'); // 讓跨網域可以存取 CORS

    if(
        empty($_POST['content'])||
        ($_POST['content'] === '[]') // 擋掉空 array 變成的字串
    ){
        $json = array(
            "ok" => false,
            "message" =>"Please add todos."
        );

        $response = json_encode($json);
        echo $response;
        die();
    }



    $content = $_POST['content'];

    $sql = 'INSERT INTO cokecode_w12_hw2(content) VALUE(?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $content);
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
        "message" => "seccess",
        "site_id" => $conn->insert_id
    );

    $response = json_encode($json);
    echo $response;

?>

