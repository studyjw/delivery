<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/xadmin.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/layui/layui.js" charset="utf-8"></script>
    <script src="/js/jquery.form.js" type="text/javascript"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="x-body">
    <form class="layui-form" id="form" onsubmit="return false;">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                用户名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="number" class="layui-form-label">
                身份证
            </label>
            <div class="layui-input-inline">
                <input type="text" id="number" name="number" required="" lay-verify="required|identity"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="tel" class="layui-form-label">
                电话
            </label>
            <div class="layui-input-inline">
                <input type="text" id="tel" name="tel" required="" lay-verify="required|phone|number"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">职务</label>
            <div class="layui-input-block">
                <input type="radio" name="token" value="1" title="发运科人员">
                <input type="radio" name="token" value="0" title="销售员" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="password" required="" lay-verify="required|password"
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                6到16个字符
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>确认密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_repass" name="rpassword" required="" lay-verify="required|password|repass"
                       autocomplete="off" class="layui-input">
                {{csrf_field()}}
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="save" lay-submit="">
                添加
            </button>
        </div>
    </form>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            password: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
        });
        //监听提交
        form.on('submit(save)', function(data){
            var formdata = $('#form').serialize();
            $.ajax({
                layerIndex:-1,
                beforeSend: function () {
                    this.layerIndex = layer.load(3, { shade: [0.5, '#393D49'] });
                },
                type:'POST',
                url:'/user/add',
                data:formdata,
                dataType:'json',
                success:function(result){
                    if(result){
                        layer.msg('添加成功!', {icon: 1, time: 1000});
                        $("form")[0].reset(); //清空表单
                    }else {
                        layer.msg('添加失败!', {icon: 2, time: 2000});
                    }
                },
                complete: function () {
                    layer.close(this.layerIndex);
                },
                error:function(msg){
                    if (msg.status == 422) {
                        var allerror ='';
                        if (msg.responseJSON[0].name!==undefined){
                            allerror += msg.responseJSON[0].name+"<br>";
                        }
                        if (msg.responseJSON[0].password!==undefined){
                            allerror += msg.responseJSON[0].password+"<br>";
                        }
                        if (msg.responseJSON[0].number!==undefined){
                            allerror += msg.responseJSON[0].number+"<br>";
                        }
                        if (msg.responseJSON[0].token!==undefined){
                            allerror += msg.responseJSON[0].token+"<br>";
                        }
                        if (msg.responseJSON[0].rpassword!==undefined){
                            allerror += msg.responseJSON[0].rpassword+"<br>";
                        }
                        if (msg.responseJSON[0].tel!==undefined){
                            allerror += msg.responseJSON[0].tel+"<br>";
                        }
                        layer.alert(allerror,{title:'提示',icon:0});
                    }
                }
            });
            return false;
        });


    });
</script>
</body>

</html>