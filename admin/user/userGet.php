<?php 
    include_once '../../fn.php';
    //sql
    $sql = "select * from users";
    //执行并返回json数据 
    echo json_encode( my_query($sql));
?>