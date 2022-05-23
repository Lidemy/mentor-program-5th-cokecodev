<?php
    require_once("conn.php");
    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    if(
        empty($_GET['site_id'])
    ){
        $json = array(
            "ok" => false,
            "message" =>"Please put site_id in url."
        );

        $response = json_encode($json);
        echo $response;
        die();
    }


    $site_id = intval($_GET['site_id']); // 用 intval() 轉成數字

    $sql = 'SELECT id, content FROM cokecode_w12_hw2 WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $site_id);
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

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $json = array(
        "ok" => true,
        "datasFromDB" => array(
            "site_id" => $row['id'],
            "content" => $row['content']
        )
    );

    $response = json_encode($json);
    echo $response;

?>

