<?php 
    include('response.php');

    $url = isset($_POST['url']) ? $_POST['url'] : null;
    if(!$url){
        return error('Đường dẫn không thể để trống');
    } 

    $url = urlencode($url);
    $url = str_replace(['%2F', '%3A'], ['/', ':'], $url);
    $string = file_get_contents($url);
    return success($string);
?>