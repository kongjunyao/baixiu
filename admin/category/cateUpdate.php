<?php 
    include_once '../../fn.php';
    
    // 获取前端修改后的数据，根据id 将数据更新回数据库 
    $id = $_GET['id'];
    $name = $_GET['name'];
    $slug = $_GET['slug'];

    //sql
    $sql = "update categories set name = '$name', slug = '$slug' where id = $id";

    //执行
    if (my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }

?>