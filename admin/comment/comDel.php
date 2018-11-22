<?php 
header('content-type:text/json;charset=utf-8');
    include_once '../../fn.php';
    // 根据前端传递id 删除对应的数据
    $id = $_GET['id'];
    //准备sql
    $sql = "delete from comments where id in ($id)";
    //执行
    my_exec($sql);

    //注意： 删除比较特殊， 删除会导致数据库总数发生变化，数据越来越少，导致分页标签个数发生变化；
    // 为了前端更方便的去动态生成分页标签， 在每次删除完成后，返回 删除后 数据库剩余的数据总数，方便前端处理分页标签；

    //查询删除完成后，数据库剩余评论总数 
    $sql1 = "select count(*) as 'total' from comments  
    join posts on  comments.post_id = posts.id";
    //执行
    $data = my_query($sql1)[0]; 

    //返回json格式的数据
    echo json_encode($data);

?>