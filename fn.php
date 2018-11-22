<?php
header('content-type:text/html;charset=utf-8');
//封装链接数据库函数
//  封装非查询语句
function my_exec($sql){
   //链接数据库     mysqli_connect('ip地址'，'用户名','密码',)
   $link = mysqli_connect('127.0.0.1','root','root','zbaixiu');
   //判断数据库是否连接失败
    if(!$link){
      echo  '数据库连接失败';
      return false;
    }
 
    
       //执行sql语句 并 判断是否执行 成功
     if(!mysqli_query($link,$sql)){
     //echo '执行错误了';
     //关闭数据库
     mysqli_close($link);
     return false;
    }
    //无论成功与否 都要关闭数据库
     mysqli_close($link);
    //  echo '执行成功了';
    return true;
}
//封装查询语句


function my_query($sql){
  //链接数据库   
$link = mysqli_connect('127.0.0.1','root','root','zbaixiu');
//判断数据库是否链接成功
    if(!$link){
      echo  '数据库连接失败';
      return false;
    }
    //获取执行sql语句返回的结果
    $res = mysqli_query($link,$sql);
    //获取返回 数据的长度
    $num = mysqli_num_rows($res);
    //判断返回的数据是否为空
    if(!$res || $num == 0){
    echo '未获取到数据';
    //关闭数据库
    mysqli_close($link);
    return false;
    }
    //遍历返回的数据  一条条的添加到$data中
    for($i = 0; $i < $num; $i++){
      $data[] = mysqli_fetch_assoc($res);
    }
    //关闭数据库
    mysqli_close($link);

    //返回data数据
    return $data;
}




        // $sql = "select * from users";
        // $data = my_exec($sql);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

//封装是否存在cookie
  function isLogin(){
    //判断cookie中是否存在 sessionid
     if(empty($_COOKIE['PHPSESSID'])){
       //跳转到登录页面
        header('location:./login.php');
     }else{
       //开启session
       session_start();
       //判断session中是否有userid
       if(empty($_SESSION['user_id'])){
          header('location: ./login.php');
       }
     }


  }
?>