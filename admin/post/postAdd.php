<?php

include_once '../../fn.php';


      $title = $_POST['title'];
      $content = $_POST['content'];
      $slug = $_POST['slug'];
      $category = $_POST['category'];
      $created = $_POST['created'];
      $status = $_POST['status'];



session_start(); //开启session 
$userid = $_SESSION['user_id'];


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


$sql = "insert into posts (title, content, slug, category_id, created, status, user_id, feature) 
        values ('$title', '$content', '$slug', $category, '$created', '$status', $userid, '$feature')";



my_exec($sql);

header('location: ../posts.php');
?>