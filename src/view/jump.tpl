<!DOCTYPE>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>错误提示</title>
    <link href='__ASSETS__/css/zui.min.css' rel='stylesheet' type='text/css'>
    <link href='__ASSETS__/css/style.css' rel='stylesheet' type='text/css'>
    <style>
        .page-404 {
            color: #afb5bf;
            padding-top: 60px;
            padding-bottom: 90px;
        }
        .text-c {
            text-align: center;
        }
        .page-404 .error-title {
            font-size: 80px;
        }
        .page-404 .error-description {
            font-size: 24px;
        }
        .ml-20 {
            margin-left: 20px;
        }
        p {
            margin-bottom: 10px;
        }
    </style>
    <script>
        var BaseConfig = {
            module: "<?php echo strtolower(request()->module()); ?>",
            controller: "<?php echo strtolower(request()->controller()); ?>",
            action: "<?php echo strtolower(request()->action()); ?>"
        };
    </script>
</head>
<body>
<article class="page-404 minWP text-c">
    <?php switch ($code) {?>
    <?php case 0:?>
        <p class="error-title">
            <span style="font-size: 80px;" class="icon icon-frown"></span>
            <span class="va-m"> 404</span>
        </p>
        <p class="error-description">
            <?php echo(strip_tags($msg));?>
        </p>
        <p class="error-info">您可以：
            <a href="javascript:;" onclick="history.go(-1)" class="btn btn-outline btn-primary btn-sm">返回上一页</a>
            <span class="ml-20">|</span>
            <a href="javascript:;" onclick="closeThisWindow()" class="btn btn-outline btn-warning btn-sm ml-20">关闭这一页</a>
        </p>
    <?php break;?>
    <?php case 1:?>
        <p class="error-title">
            <span style="font-size: 80px;" class="icon icon-smile"></span>
            <span class="va-m"> 200</span>
        </p>
        <p class="error-description">
            <?php echo(strip_tags($msg));?>
        </p>
        <p class="error-info">页面自动
            <a id="href" href="<?php echo($url);?>" class="btn btn-outline btn-primary btn-sm">跳转</a>
            <span class="ml-20">|</span>
            <a href="javascript:;" class="btn btn-sm ml-20">等待时间： <b id="wait"><?php echo($wait);?></b></a>
        </p>
        <script>
            (function(){
                var wait = document.getElementById('wait'),
                        href = document.getElementById('href').href;
                var interval = setInterval(function(){
                    var time = --wait.innerHTML;
                    if(time <= 0) {
                        location.href = href;
                        clearInterval(interval);
                    };
                }, 1000);
            })();
        </script>
    <?php break;?>
    <?php } ?>
</article>
</body>
    <script src="__ASSETS__/js/jquery.min.js" type="text/javascript"></script>
    <script src="__ASSETS__/js/zui.min.js" type="text/javascript"></script>
    <script src="__ASSETS__/js/util.js" type="text/javascript"></script>
    <script>
        function closeThisWindow(){
            if(typeof parent.CloseFrame == "function"){
                console.log(BaseConfig.module+BaseConfig.controller+BaseConfig.action);
                parent.CloseFrame(BaseConfig.module+BaseConfig.controller+BaseConfig.action);
            }else{
                window.opener=null;window.close();
            }
        }
    </script>
</html>

