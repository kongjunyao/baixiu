<?php 
    //返回轮播图数据接口 
    include_once '../../fn.php';
    //sql
    $sql = "select value from options where id = 10";
    //执行
    $data = my_query($sql)[0]['value'];

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    echo $data; //返回json格式的数据

?>