<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-配货管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/xadmin.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/md5.min.js"></script>
    <script src="/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/js/xadmin.js"></script>
    <script type="text/javascript" src="/js/cookie.js"></script>
</head>

<body>
    <div class="x-body">
        <blockquote class="layui-elem-quote">
            <fieldset class="layui-elem-field">
                <legend>数据统计</legend>
                <div class="layui-field-box">
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-body">
                                <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim=""
                                    lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                                    <div carousel-item="">
                                        <ul class="layui-row layui-col-space10 layui-this">
                                            <li class="layui-col-xs2">
                                                <a href="javascript:;" class="x-admin-backlog-body body-zero">
                                                    <h3 class="h3-yzm">订单数</h3>
                                                    <p class="p-yzm"><cite id="order">N/A</cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs2">
                                                <a href="javascript:;" class="x-admin-backlog-body body-one">
                                                    <h3 class="h3-yzm">已发货</h3>
                                                    <p class="p-yzm"><cite id="shipped">N/A</cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs2">
                                                <a href="javascript:;" class="x-admin-backlog-body body-two">
                                                    <h3 class="h3-yzm">未发货</h3>
                                                    <p class="p-yzm"><cite id="unshipped">N/A</cite></p>
                                                </a>
                                            </li>
                                            <li class="layui-col-xs2">
                                                <a href="javascript:;" class="x-admin-backlog-body body-three">
                                                    <h3 class="h3-yzm">会员数</h3>
                                                    <p class="p-yzm">
                                                        <cite id="users">N/A</cite></p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </blockquote>
        <blockquote class="layui-elem-quote">
            <fieldset class="layui-elem-field">
                <legend>系统介绍</legend>
                <div class="layui-field-box systeam">
                    对某企业发货过程进行管理，内置系统管理员角色，销售岗人员登录系统录入订单信息，之后发运科工作人员登录系统后可看到录入的订单信息，
                    并进行如下的操作：查看订单信息；计算订单货物数量、重量等；系统按照所合作的物流公司负责的地理区划范围，根据收货地址自动匹配该负责的物流公司；
                    系统通过特定的算法确定订单处理的优先次序，并可生成发货清单，可导出为Excel表格保存。
                </div>
            </fieldset>
        </blockquote>
    </div>
    <script>
        $.ajax({
            type: 'get',
            url: '/welcome/index',
            dataType: 'json',
            success: function (data) {
                $("#order").html(data.order);
                $("#shipped").html(data.shipped);
                $("#unshipped").html(data.unshipped);
                $("#users").html(data.users);
            },
        });
    </script>
</body>

</html>