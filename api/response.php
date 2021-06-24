<?php 
    header('Content-Type: application/json');
    header('Accept: application/json');

    function error($msg, $code = 400){
        echo json_encode([
            'message' => $msg,
            'status' => false,
            'code' => $code
        ]);
    }

    function success($data, $code = 200){
        echo json_encode([
            'data' => $data,
            'status' => true,
            'code' => $code
        ]);
    }
?>