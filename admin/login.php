
<?php
//引入aside.php文件
include_once '../fn.php';
//判断是否获取数据
if(!empty($_POST)){
$email = $_POST['email'];
$psw = $_POST['password'];

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';


//判断用户名或者密码是否为空
if(empty($email) || empty($psw)){
  $msg = '用户名或者密码为空';
}else{
  //准备sql语句
  $sql = "select * from users where email = '$email'";
  //调用函数操作数据库
  $data = my_query($sql);
  //判断函数返回值是否为空
  if(empty($data)){
    $msg = '用户名不存在';
  }else{
    //将返回的二维数组变成一维数组
    $data = $data[0];
    //如果 密码和数据库搜索的密码一致
    if($psw === $data['password']){
      //开启session
      session_start();
      //将data的id赋值给session的user_id
      $_SESSION['user_id'] = $data['id'];
      //跳转到主页面
      header('location: ./index1.php');
    }else{
      $msg = '密码错误';
    }
  }
}
}


?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->



      <?php   if(!empty($msg))  { ?>
       <div class="alert alert-danger">
         <!--输出错误信息-->
        <strong>错误！</strong> <?php echo $msg?>
      </div> 
      <?php } ?>



      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
               <!--将获取的邮箱的值添加到邮箱的 value  输入错密码是也可以显示邮箱-->
        <input id="email"
               type="email"
               name="email"
               class="form-control"
               placeholder="邮箱" 
               value = "<?php  echo !empty($msg)? $email: '' ?>"
               autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password"
         type="password" 
         name="password"
         class="form-control" 
         placeholder="密码">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>
