<?php 
    include_once '../../fn.php';
    
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';

    // 获取前端修改后的数据，根据id 将数据更新回数据库 
    $id = $_GET['id'];
    $email = $_GET['email'];
    $slug = $_GET['slug'];
    $nickname = $_GET['nickname'];
    $password = $_GET['password'];
    //sql
    $sql = "update users set email = '$email', slug = '$slug', nickname = '$nickname', password = '$password' where id = '$id'";
    echo $sql;
    //执行
    if (my_exec($sql)) {
        echo 'success!';
    }else {
        echo 'error!';
    }

?>