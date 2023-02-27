<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "classResize.php";

function store_uploaded_image($nome, $new_img_width, $new_img_height) {
    
    $target_dir = "../uploads/";
    $target_file = $nome;
    
    $image = new SimpleImage();
    $image->load($target_dir.$target_file);
    $image->resize($new_img_width, $new_img_height);
    $image->save($target_dir.$target_file);
    return $target_file; //return name of saved file
}


$nome = store_uploaded_image("teste.jpg",'310', '310');
echo $nome;




// function createImage($inNome, $width, $height)
// {
//     $nome = "../uploads/".$inNome;
//     $src_img = ImageCreateFromJpeg($nome);

//     $old_x = ImageSX($src_img);
//     $old_y = ImageSY($src_img);
//     $dst_img = ImageCreateTrueColor($width, $height);
//     ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $width, $height, $old_x, $old_y);

//     ImageJpeg($dst_img, $nome, 80);

//     ImageDestroy($dst_img);
//     ImageDestroy($src_img);
// }