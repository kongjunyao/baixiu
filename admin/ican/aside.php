<?php 
//获取sessionid
$id = $_SESSION['user_id'];
//准备sql语句
$sql =  "select * from users where id = $id";
//执行sql语句
$data = my_query($sql);
//将data二维数组转换成一维数组
$data = $data[0];
//判断$page是否在数组中
$isPost = in_array($page,['posts','post-add','categories']);
$isSet = in_array($page,['settings', 'nav-menus', 'slides']);
?>




<div class="aside">
    <div class="profile">
                                   <!--动态渲染头像和用户名-->
      <img class="avatar" src="../<?php echo $data['avatar']?>">
      <h3 class="name"><?php echo $data['nickname']?></h3>
                                       <!--打印输出当前页面的文件名-->
      <p  style = "color : red"><?php  echo $page?></p>
    </div>



    <ul class="nav">
    <!--首页-->
    <!--判断$page是否等于 index1 如果是则添加active类名-->
      <li class="<?php echo $page == 'index1' ? 'active':''?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>


      <!--文章-->
      <!--判断$isPost是否为true 如果是则添加active类名-->
      <li class="<?php echo $isPost ? 'active':''?>">
                                                      <!--箭头变成朝下-->
        <a href="#menu-posts" class="<?php echo $isPost ? '':'collapsed'?>" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>                                      
                                                  <!--展开子页面-->
        <ul id="menu-posts" class="collapse  <?php echo $isPost ? 'in':''?>">
                                 <!--判断$page是否等于该页面文件名  如果是 添加active类名-->
          <li class="<?php echo $page === 'posts'?'active':''?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $page === 'post-add'?'active':''?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $page === 'categories'?'active':''?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>



      <!--评论-->
      <!--判断$page是否等于该文件名  如果等于则添加active类名-->
      <li class="<?php echo $page == 'comments' ? 'active':''?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <!--用户-->
       <!--判断$page是否等于该文件名  如果等于则添加active类名-->
      <li class="<?php echo $page == 'users' ? 'active':''?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <!--设置-->
       <!--判断$isSet是否为true 如果是则添加active类名-->
      <li class="<?php echo $isSet ? 'active':''?>">
                                                  <!--箭头变成朝下-->
        <a href="#menu-settings" class="<?php echo $isSet ? '':'collapsed'?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
                                                    <!--展开子页面-->
        <ul id="menu-settings" class="collapse <?php echo $isSet ? 'in':''?>">
                         <!--判断$page是否等于该页面文件名  如果是 添加active类名-->
          <li class="<?php echo $page === 'nav-menus'?'active':''?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $page === 'slides'?'active':''?>"><a href="slides.php">图片轮播</a></li>
          <li class="<?php echo $page === 'settings'?'active':''?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>