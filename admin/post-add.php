<?php
include_once '../fn.php';
isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="./post/postAdd.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" style="display:none" ></textarea>
             <div id="content-box"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id="strong">slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none" id="img">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php  $page =  'post-add'?>


  <?php  include_once './ican/aside.php' ?>
 

<!-- 分类模版 -->
  <script type="text/html" id="tmp-cate">
    {{ each list v i }}
      <option value="{{ v.id }}">{{ v.name }}</option>    
    {{ /each }}
  </script>



  <!-- 状态模版 -->
  <!-- 在模版中 对象自身用 $data -->
  <script type="text/html"  id="tmp-state">
    {{ each $data v k }}
    v 指的是
      <option value="{{ k }}">{{ v }}</option>        
    {{ /each }}
  </script>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <!--<script src="../assets/vendors/wangEditor/wangEditor.js"></script>-->
  <script>NProgress.done()</script>

<script>
//发送请求获取分类数据
$.ajax({
  url : './category/cateGet.php',
  dataType : 'json',
  success : function(info){
    console.log(info);
    //进行数据的链接渲染
    $('#category').html( template('tmp-cate', {list : info}) );
  }
})


//定义一个对象用于中英转换
var state = {
      drafted: '草稿',
      published: '已发布',
      trashed: '回收站'
    }
//将状态数据用模板渲染链接
 $('#status').html(template('tmp-state', state));
//标签与输入同步    input事件方法   input中输入就会触发
 $('#slug').on('input', function () {
      //给strong标签同步内容
      $('#strong').text( $(this).val() || 'slug');
    })

 //日期输入栏自动默认当前时间（利用）
$('#created').val(moment().format('YYYY-MM-DDTHH:mm'));



//给文件输入框注册change事件
$('#feature').on('change', function(){
//获取获取文件中的第一个
var file = this.files[0];
//将文件的路径地址赋值给url
var url = URL.createObjectURL(file);
$('#img').attr('src',url).show();

})
</script>

<script type="text/javascript" src="../assets/vendors/wangEditor/wangEditor.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!--<script type="text/javascript" src="../wangEditor.js"></script>-->
    <script type="text/javascript">
        var E = window.wangEditor;
        var editor = new E('#content-box');
        editor.customConfig.onchange = function (html){
        $("#content").val(html)
        };
        editor.customConfig.menus = [
            'head',  // 标题
            'bold',  // 粗体
            'fontSize',  // 字号
            'fontName',  // 字体     
            'underline',  // 下划线
            'strikeThrough',  // 删除线
            'foreColor',  // 文字颜色
            'backColor',  // 背景颜色
            'link',  // 插入链接
            'list',  // 列表 
            'emoticon',  // 表情
            'image',  // 插入图片
            'table',  // 表格
            'video',  // 插入视频    
            'undo',  // 撤销
            'redo'  // 重复
        ];
        editor.create()
        
    </script>


</body>
</html>
