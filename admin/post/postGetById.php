<?php 
    include_once '../../fn.php';
    // 根据前端传递id ,返回对应的文章的数据
    $id = $_GET['id'];
    //sql
    $sql = "select * from posts where id = $id";
    //执行
    $data = my_query($sql)[0];

    //返回json数据
    echo json_encode($data);

?>
