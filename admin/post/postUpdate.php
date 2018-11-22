<?php


// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

include_once '../../fn.php';

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
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


//echo $feature;

// 准备 sql 语句
  if ( empty( $feature ) ) {
    // 为空, 不需要更新图片
    $sql = "update posts set title = '$title' , content = '$content' , slug = '$slug' , category_id = '$category' , 
created = '$created' , status = '$status'  where id = '$id' ";
  }
  else {
    // 需要更新图片, 多加了图片的更新字段
    $sql = "update posts set title = '$title' , content = '$content' , slug = '$slug'  , category_id = '$category' , 
created = '$created' , status = '$status' , feature = '$feature'  where id = '$id' ";
  }

// $sql = "update posts set title = $title, content = $content, slug = $slug, category = $category, 
// created = $created, status = $status, feature = $feature  where id = $id ";

my_exec( $sql );
// if ( my_exec( $sql ) ) {
//     // 执行成功, 跳转到 list.php
//   header('location : ../posts.php');
//   }
//   else {
//     echo "执行失败";
//   }


echo '执行成功'

?>