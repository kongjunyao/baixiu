<?php 
    include_once '../../fn.php';
    //根据前端传递页码 和每页数据的条数 返回对应的数据； 
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //截取起始索引 = (页码 - 1) * 10  = (页码 - 1) * 每页数据条数
    $start = ($page - 1) * $pageSize;

    
    //查询评论的数据
    $sql = "select comments.*, posts.title from comments  -- 查询评论数据
            join posts on  comments.post_id = posts.id   -- 联合文章表 
            order by comments.id  -- 通过id进行升序排序
            limit $start, $pageSize  -- 分页   一页10条  limit 起始索引， 截取长度";






    //执行 
    $data = my_query($sql);

    //返回json格式 
    echo  json_encode($data); 
?>