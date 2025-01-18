<?php

$cache_dir = '.cache/';
if (!(isset($_REQUEST['url']) /*filter_var($_REQUEST['url'], FILTER_VALIDATE_URL)*/  )) {
    echo '';
    exit();
}

$url = $_REQUEST['url'];
if(str_contains(strtolower($url), '%3f')){
    $url = urldecode($url);
}




$ext = strtolower(substr(strrchr($url, '.'), 1));
$img_ext = ['webp' => 'webp', 'png' => 'png', 'avif' => 'avif', 'jpg' => 'jpeg', 'jpeg' => 'jpeg', 'jfif' => 'jpeg'];
if (in_array($ext, array_keys($img_ext))) {
    $type = 'image/' . $img_ext[$ext];
} else {
    $type = 'text/html';
}



$dst = imagecreatefromstring(file_get_contents($url));
if($dst !== FALSE) {
    header('Content-Type: ' . $type);
    $name = mb_substr(mb_strrchr($_REQUEST['url'], '.'), 1) . '.avif';
    imageavif($dst, $name);
    imagedestroy($dst);
    echo file_get_contents($name);
    unlink($name);
    
}else{
    echo '';
}
exit();
