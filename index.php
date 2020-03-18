<?php
if(!empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['code'])) {
    //访问首页，存储cookie数据
    $cookie_file = dirname(__FILE__) . '/cookie.txt';
//设置post的数据
    $code = $_POST['code'];
    $token = $_POST['token'];
    $post = array(
        //用户名
        'username'=>'694629075@qq.com',
        //密码
        'userpwd'=> md5('psk775521.'),
        'token'=>$token,
        'b_type'=>'1',
        'vifrom'=>'31854759350919055655554940143542',
        'lang'=>'96a39678a4203fbccdae04f6e580e696',
        //验证码
        'code'=>$code,
    );
    $login_url = "https://www.chengmi.cn/member/ajax/User.ashx";
    $referer = 'Referer: https://www.chengmi.cn/';
    $ch=curl_init($login_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);    //来路模拟
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    $res = curl_exec($ch);
    curl_close($ch);
    $login_pass = "https://www.chengmi.cn/userpanel";
    $ch=curl_init($login_pass);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,$referer);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file); //使用提交后得到的
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 10);
    //cookie数据cookie数据做参数
    $retValue = curl_exec($ch);
    $ee       = curl_getinfo($ch);
    preg_match('/<td height="36" align="center" class="hsac" style="font-size: 18px;">
                               (.*)
                            <\/td>/',$retValue,$account_money);
    preg_match('/<td height="36" align="center" class="hsac" style="font-size: 18px;">
                            
                               (.*)
                                
                            <\/td>/',$retValue,$freeze_money);
    preg_match('/<td height="36" align="center" class="yhym" style="font-size: 18px; color: Green;">
                                (.*)
                            <\/td>/',$retValue,$avaliable_money);
    echo "您的账户余额还有：".$account_money[1]."\r\n"."<br/>";
    echo "您的冻结余额还有：".$freeze_money[1]."\r\n"."<br/>";
    echo "您的可用余额还有：".$avaliable_money[1]."\r\n"."<br/>";
    exit;
}

function getToken(){
    $cookie_file =dirname(__FILE__) . '/cookie.txt';
    $home_url = 'https://www.chengmi.cn/';
    $ch=curl_init($home_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    $html = curl_exec($ch);
    curl_close($ch);
    preg_match('/"login_token".*value="(.*)"/',$html,$arr);
    getImg();
    return $arr[1];
}
function getImg(){
    $verify_code_url = "https://www.chengmi.cn/member/code.aspx";
    $cookie_file = dirname(__FILE__) . '/cookie.txt';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $verify_code_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $img = curl_exec($curl);
    curl_close($curl);
    $fp = fopen("verifyCode.jpg","w");
    fwrite($fp,$img);
    fclose($fp);
    return 'data:image/jpeg;base64,'.base64_encode($img);
}
?>
<html>
<head>
    <title>PHP cURL 模拟橙米网登录</title>
    <meta charset="utf-8">
</head>
<body>
<form method="post">
    <input type="hidden" name="token" value="<?= getToken() ?>">
    <div>橙米网登录邮箱/手机号：<input type="text" name="user" value="694629075@qq.com"></div>
    <div>橙米网登录密码：<input type="password" name="password" value="psk775521."></div>
    <div>橙米网登录验证码：<input type="text" name="code"><img src="verifyCode.jpg" alt=""   id='img'></div>
    <div><input type="submit" value="提交"></div>
</form>
</body>
</html>


