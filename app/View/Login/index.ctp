<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>登录</title>
        <link href="<?php echo $this->base; ?>/css/base.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->base; ?>/css/skins/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/functions.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo $this->base; ?>/js/asyncbox/asyncbox.js"></script>
    </head>
<body class="loginWeb">
    <div class="loginBox">
        <div class="innerBox">
            <div class="logo"> <img src="/img/Admin/logo.png" /></div>
            <form id="form1" action="" method="post">
                <div class="loginInfo">
                    <ul>
                        <li class="row1">登录账号：</li>
                        <li class="row2"><input class="input" name="email" id="email" size="30" type="text" /></li>
                    </ul>
                    <ul>
                        <li class="row1">登录密码：</li>
                        <li class="row2"><input class="input" name="pwd" id="pwd" size="30" type="password" /></li>
                    </ul>
                </div>
                <input type="hidden" name="op_type" id="op_type" value="1"/>
            </form>
            <div class="clear"></div>
            <div class="operation"><button class="btn submit">登录</button>   <button class="btn findPwd">忘记密码？</button></div>
        </div>
    </div>
    <script type="text/javascript">
       var jsroot ='<?php echo $rooturl;?>';
        $(function(){
            $(".submit").click(function(){
                $("#op_type").val("1");
                var username = $("#email").val();
                var pwd = $("#pwd").val();
            	username = username.replace("&nbsp","");
                if($("#email").val()==''||$("#pwd").val()==''||$("#verify_code").val()==''){
                    popup.alert("填写完整方可登陆");
                    return false;
                }
                var params = "username=" + encodeURIComponent(username) + "&pwd=" + encodeURIComponent(pwd);
                handledata('post',jsroot+"login/login",params,'json',logindataResponse);
            });
            $(".findPwd").click(function(){
                $("#op_type").val("2");
                if($("#email").val()==''){
                    popup.alert("填写了你的邮箱方可找回密码");
                    return false;
                }
                if($("#verify_code").val()==''){
                    popup.alert("请写验证码方可找回密码");
                    return false;
                }
                commonAjaxSubmit();
            });
        });
        function logindataResponse(request){
        	if(request.status==1){
        		location.href=jsroot;
        	}
        	if(request.status==200){
        		location.href=jsroot+"Backstage";
        	}else {
       		 	popup.alert(request.info);
          		return false;
        	}
        }
    </script>
</body>
</html>