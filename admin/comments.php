<?php
include_once '../fn.php';
isLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
          <!--<button class="btn btn-warning btn-sm">批量拒绝</button>-->
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>

               <!--分页的父容器-->
           <div class="page-box pull-right"></div>


      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>


        <tbody>
          <!--<tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>-->
          
        </tbody>
      </table>
    </div>
  </div>



<?php  $page =  'comments'?>

<?php  include_once('./ican/aside.php') ?>




<!--模板-->
  <script type="text/html" id="tmp">
  {{each list v i}}
   <tr>
            <td class="text-center" data-id={{v.id}}><input class="tb-chk" type="checkbox"></td>
            <td>{{v.author}}</td>
            <td>{{v.content.substr(0,20)+'...'}}</td>
            <td>{{v.title}}</td>
            <td>{{v.created}}</td>
            <td>{{state[v.status]}}</td>
            <td class="text-right" data-id="{{v.id}}">
            {{if v.status == "held"}}
              <a href="javascript:;" class="btn btn-info btn-xs btn-apporved">批准</a>
            {{/if}}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>
  {{/each}}
  
  </script>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script> 
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>


  

  <script>
   var state = {
      held: '待审核',
      approved: '准许',
      rejected: '拒绝',
      trashed: '回收站'
   }
 var  currentPage = 1; //记录当前页





//封装渲染函数
function render(page){
  //发送ajax请求
$.ajax({
 url: './comment/comGet.php',
 type : 'get',
 data : {
   page : page || 1,
   pageSize : 10
 },
 dataType : 'json',
 success :  function(info){
   //console.log(info);
  var obj = {
    list : info,
    state : state
  }
var str = template('tmp',obj);
$('tbody').html(str);

//将 批量按钮 和全选框进行重置 
          $('.th-chk').prop('checked', false); //取消选中
          $('.btn-batch').hide(); //隐藏
 }
})
}

render();



//封装分页函数
function setPage(page){
//发送ajax请求
$.ajax({
  url : './comment/comtotal.php',
  dataType : 'json',
  success : function(info){
    //console.log(info);
    $('.page-box').pagination(info.total,{
            prev_text: '上一页',
            next_text: '下一页',
            current_page: page - 1 || 0,  //默认选中第一页
            num_display_entries: 5, //连续主体的格式
            num_edge_entries: 1, //首尾显示个数
            load_first_page: false, //页面初始化时不执行回调函数 
            callback : function(index){
             render(index + 1);
             currentPage =  index + 1;
            }
    })
  }
})
}
setPage();


//批量删除
$('tbody').on('click','.btn-del', function(){
  //获取点击元素父元素的data-id
   var id = $(this).parent().attr('data-id');
   //发送ajax请求
   $.ajax({
    url : './comment/comDel.php',
    data : {id : id},
    dataType: 'json',
    success : function(info){
     console.log(info);
    //在渲染和重新生成分页标签之前 判断 currnetPage值是否大于数据库的最大页码
          //获取数据库数据的最大页码
          var maxPage = Math.ceil(info.total / 10);
          //判断currentPage是否越界
          if (currentPage > maxPage) {
            currentPage = maxPage;
          }  
          //重新渲染分页 
     render(currentPage);
     setPage(currentPage);
    }
   })
})


//批量批准 
$('tbody').on('click','.btn-apporved', function(){
  //获取点击元素的父级元素
   var id = $(this).parent().attr('data-id');
   //发送请求
   $.ajax({
    url : './comment/comApproved.php',
    data : {id : id},
    success : function(info){
    //console.log(info);
    //重新渲染页面
     render(currentPage);
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
   $('.btn-batch').show();
 }else{
   $('.btn-batch').hide();
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
   $('.btn-batch').show();
 }else{
   $('.btn-batch').hide();
 }

})


//封装获取id的函数
function getId(){
 var ids = [];
 //遍历选中的单选框，将他们的父级元素的data-id存储到数组中
 $('.tb-chk:checked').each(function(index,ele){
      ids.push($(ele).parent().attr('data-id'));    
 })
 return ids.join();
}



//批量准许 按钮注册点击事件
$('.btn-approveds').click(function(){
//调用函数获取id
var ids = getId();
//发送ajax请求
$.ajax({
  url : './comment/comApproved.php',
  data : {id : ids},
  success : function(){
    //渲染当前页面
    render(currentPage);
  }
})
})

//批量删除数据
//给批量删除注册点击事件
$('.btn-dels').click(function(){
 //调用函数获取选中的
var ids = getId();
//发送ajax请求
$.ajax({
  url : './comment/comDel.php',
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


  </script>



</body>
</html>
