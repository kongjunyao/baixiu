<?php

 // 获取所有的分类数据，进行返回 
    include_once '../../fn.php';
    //sql
    $sql = "select * from categories";
    //执行
    $data = my_query($sql);
    //返回
    echo json_encode($data);


?>