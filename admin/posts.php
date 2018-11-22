
<?php
include_once '../fn.php';
isLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm btn-dels" href="javascript:;" style="display: none">批量删除</a>
        <!--分页 容器-->
         <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class="th-chk"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox" ></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
  <?php  $page =  'posts'?>
 <?php  include_once './ican/aside.php' ?>
  <?php  include_once  './ican/edit.php' ?>
<!--模板-->
  <script  type="text/html" id="tmp">
  {{ each list v i}}
    <tr>
            <td class="text-center" data-id={{v.id}} ><input type="checkbox" class="tb-chk"></td>
            <td>{{ v.title}}</td>
            <td>{{v.nickname}}</td>
            <td>{{v.name}}</td>
            <td class="text-center">{{v.created}}</td>
            <td class="text-center">{{state [v.status]}}</td>
            <td class="text-center" data-id={{v.id}}>
              <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>
  {{ /each }}
  </script>
   


<!-- 分类模版 -->
  <script type="text/html" id="tmp-cate">
    {{ each list v i }}
      <option value="{{ v.id }}">{{ v.name }}</option>    
    {{ /each }}
  </script>

  <!-- 状态模版 -->
  <!-- 在模版中 对象自身用 $data -->
  <script type="text/html" id="tmp-state">
    {{ each $data v k }}
      <option value="{{ k }}">{{ v }}</option>        
    {{ /each }}
  </script>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.js"></script>
  <script>NProgress.done()</script>


  <script>
  //  定义对象用于中英转换
  var state = {
      drafted: '草稿',
      published: '已发布',
      trashed: '回收站'
    }
  //  定义当前页面
    var currentPage =  1;

//渲染函数
  function render(page){
    $.ajax({
      url : './post/postGet.php',
      dataType : 'json',
      data : {
        page : page  || 1,
        pageSize : 10
      },
      success : function(info){
      $('tbody').html(template('tmp',{list : info, state : state}));
      //将 批量按钮 和全选框进行重置 
          $('.th-chk').prop('checked', false); //取消选中
          $('.btn-dels').hide(); //隐藏

      },
      error : function(){
        console.log("代码出错了");
      }

      
    })
  }
  render();
  

//分页函数
function setPage(page){
  //发送请求
   $.ajax({
      url : './post/postTotal.php',
      dataType : 'json',
      success : function(info){
        $('.page-box').pagination(info.total, {
            prev_text: '上一页',
            next_text: '下一页',
            num_display_entries: 5,//主体的个数,
            num_edge_entries: 1, //首尾的个数
            current_page: page - 1 || 0, //默认选中页面
            load_first_page: false, //页面初始化时不执行回调函数
            callback: function (index) {
              //index 当前页码对应索引值 
              render(index + 1);
              //记录当前页 
              currentPage = index + 1;

            }
        })
      }
   })
}

setPage();

//删除文章
$('tbody').on('click','.btn-del',function(){
   //获取点击元素的父级的id
   var id = $(this).parent().attr('data-id');
    //发送请求
   $.ajax({
     url : './post/postDel.php',
     data : { id : id},
     dataType : 'json',
     success : function(info){

        var maxPage = Math.ceil(info.total / 10);
         //判断当前页是否大于服务器的最大页码
         if (currentPage > maxPage) {
           currentPage = maxPage;
         }
         //重新渲染分页
        render(currentPage);
        setPage(currentPage);
     },
     error : function(){
       console.log('执行错误')
     }
   })
})


//给全选框注册改变事件
$('.th-chk').change(function(){
  //将全选框的状态赋值给单选框
 var value = $(this).prop('checked');
 $('.tb-chk').prop('checked',value);
//如果全选框被选中则显示批量操作   否则隐藏
 if(value){
   $('.btn-dels').show();
 }else{
   $('.btn-dels').hide();
 }
})


//给单选框注册改变事件
$('tbody').on('change','.tb-chk',function(){
  //如果单选框的长度与单选框选中的长度一直则全选框变为选中
  if($('.tb-chk').length == $('.tb-chk:checked').length){
    $('.th-chk').prop('checked',true);
  }else{
    $('.th-chk').prop('checked',false);
  }
//如果单选框选中的长度大于0则批量操作显示
 if($('.tb-chk:checked').length > 0){
   $('.btn-dels').show();
 }else{
   $('.btn-dels').hide();
 }

})

//封装获取id函数
function getId(){
 var ids = [];
 //遍历选中的单选框，将他们的父级元素的data-id存储到数组中
 $('.tb-chk:checked').each(function(index,ele){
      ids.push($(ele).parent().attr('data-id'));    
 })
 return ids.join();  //[id1,id2,id3]
}



$('.btn-dels').click(function(){
 //调用函数获取选中的
var ids = getId();
//发送ajax请求
$.ajax({
  url : './post/postDel.php',
  data : {id : ids},
  dataType : 'json',
  success : function(info){
    console.log(info);
    //在渲染和重新生成分页标签之前 判断 currnetPage值是否大于数据库的最大页码
          //获取数据库数据的最大页码
          var maxPage = Math.ceil(info.total / 10) ;
          //判断currentPage是否越界
          if (currentPage > maxPage) {
            currentPage = maxPage;
          }   
          //重新渲染页面
     render(currentPage);
         //重新分页
     setPage(currentPage);
  },
  error: function(err) {
    console.log(err)
  }
})
})




// 准备模态框数据
//分类下拉表
$.ajax({
  url : './category/cateGet.php',
  dataType : 'json',
  success : function(info){
    //用模板引擎将返回的数据渲染到catagory
     $('#category').html( template( 'tmp-cate',{list : info} ) );
  }
})

//准备状态栏数据
var state = {
      drafted: '草稿',
      published: '已发布',
      trashed: '回收站'
    }
    //用模板引擎将 state渲染到status上
$('#status').html( template('tmp-state', state));

//给slug注册input事件  将输入的值赋值给strong  （默认值是slug）
$('#slug').on('input',function(){
  $('#strong').text($(this).val() || 'slug');
})

//给feature注册change事件 
$('#feature').on('change', function(){
  //将文件的第一个赋值给file
  var file = this.files[0];
  // 新建文件地址
  var url = URL.createObjectURL(file);
  //将文件的地址赋值给img的src属性并且显示
  $('#img').attr('src', url).show();
})
//用日期插件规范当前你日期格式  并且渲染到页面
$('#created').val( moment().format('YYYY-MM-DDTHH:mm'));


//利用富文本编辑器插件  添加富文本编辑器
var E = window.wangEditor;
var editor = new E('#content-box');
// 将富文本编辑器中的内容和输入框同步
editor.customConfig.onchange = function(html){
  $('#content').val(html);
}
//创建富文本编辑器
editor.create();


//注册事件托管
$('tbody').on('click','.btn-edit',function(){
  //获取父级元素的id
  var id = $(this).parent().attr('data-id');
 //发送请求
  $.ajax({
    url : './post/postGetById.php',
    dataType : 'json',
    data : {id : id},
    success : function(info){
        console.log(info);
        //模态框显示
      $('.edit-box').show();
       //标题等于数据返回的标题
      $('#title').val(info.title);
        //slug等于数据返回的slug(包括strong标签)
      $('#slug').val(info.slug);
      $('#strong').text(info.slug);
      //把图片的src属性修改到正确路径并且显示
      $('#img').attr('src', '../'+info.feature).show();
        //用日期插件把数据渲染到created
      $('#created').val(moment(info.created).format('YYYY-MM-DDTHH:mm'));
       //把数据渲染到富文本编辑器和文本域
      editor.txt.html(info.content);
      $('#content').val(info.content);
        //把id赋值  方便找寻数据
      $('#id').val(info.id);
        //如果那个option的value等于数据返回的category_id，那么它的selected属性就是true
      $('#category option[value='+ info.category_id +']').prop('selected', true);
        //如果那个option的value等于数据返回的status，那么它的selected属性就是true
      $('#status option[value=' + info.status + ']').prop('selected', true);

    }
  })
 
 //6-放弃
    $('.btn-cancel').click(function () {
      $('.edit-box').hide(); //隐藏模态框
    })


$('.btn-update').click(function(){
//用formate发送请求  new出FormData对象 取第一项数据
var formData = new FormData($('#editForm')[0]);
//发送请求
  $.ajax({
    url : './post/postUpdate.php',
    type : 'post',
    data : formData,    //xhr.send(formData)
    contentType: false,    //让ajax不在设置请求头
    processData: false,    //让ajax不在内部进行数据处理   数据由formData进行处理
    success : function(info){
      console.log(info);
      $('.edit-box').hide();//模态框隐藏
      render(currentPage);//重新渲染页面
    }
  })
})
})

  </script>
</body>
</html>
