<?php


include_once '../../fn.php';



$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$feature = ''; 

$file = $_FILES['feature'];
if ( $file['error'] === 0 ) {
        //文件名要随机生成，但是后缀名不能变
        $ext = strrchr($file['name'], '.'); //后缀名
        $newName = 'uploads/'. time() . rand(1000, 9999) . $ext; //新文件名 
        //转移临时文件位置 
        move_uploaded_file($file['tmp_name'], '../../' . $newName);
        //保存新文件路径
        $feature = $newName;        
    }



if(empty($file)){
    
}

$sql = "insert into users (email, slug,nickname,password,avatar ) values ('$email', '$slug','$nickname','$password','$feature')";


if (my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
    




?>