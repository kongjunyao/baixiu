<?php
header('content-type:text/html;charset=utf-8');
include_once '../../fn.php';
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';

// $file =  $_FILES['image'];
// if($file['error'] == 0){
//   $ext = strrchr($file['name'], '.');
//   $newName = 'uploads/' . time(). rand(1000, 9999). $ext; 
//   move_uploaded_file($file['tmp_name'], '../../' . $newName);



 //$info['image'] = $newName;
 $info['text'] = $_POST['text'];
 $info['icon'] = $_POST['icon'];
 $info['title'] = $_POST['title'];
 $info['link'] = $_POST['link'];


// echo '<pre>';
// print_r($info);
// echo '</pre>';


 $sql =  'select value from options where id = 9';

 $str = my_query($sql)[0]['value'];

 $arr = json_decode($str, true);

 $arr[] = $info;

$str = json_encode($arr,JSON_UNESCAPED_UNICODE);

echo $str;

$sql = "update options set value = '$str' where id = 9";

my_exec($sql);





?>