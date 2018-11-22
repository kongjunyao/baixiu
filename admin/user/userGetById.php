<?php

//根据前端传递id，返回对应分类数据接口 
    include_once '../../fn.php';
    //获取id
    $id = $_GET['id'];
    //sql
    $sql = "select * from users where id = $id";
    //执行
    $data = my_query($sql)[0];
    //返回json数据 
    echo  json_encode($data);

?>