<?php
if(!empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['code'])) {
    //访问首页，存储cookie数据
    $cookie_file = dirname(__FILE__) . '/cookie.txt';
//设置post的数据
    $code = $_POST['code'];
    $post = array(
        'unme' => '694629075@qq.com',
        'upss' => md5('psk775521.'),
        'module' => 'login',
        'screenX' => '1920',
        'screenY' => '1080',
        'rtn' => '',
        'isAuto' => '0',
        'langsite' => '34066402399b3dc318ffc57180d714ee',
        'codes' => $code,
    );
    $login_url = "https://www.cndns.com/Ajax/Login.ashx";
    $referer = 'Referer: https://www.cndns.com/members/signin.aspx';
    $ch=curl_init($login_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);    //来路模拟
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post));
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    $res = curl_exec($ch);
    curl_close($ch);
    $login_pass = "https://www.cndns.com/userhome/";
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
    preg_match_all('/<dt>(.*)<\/dt>/',$retValue,$arr);
    echo "您的账户余额还有：".$arr[1][0]."\r\n"."<br/>";
    exit;
}

function getToken(){
    $cookie_file =dirname(__FILE__) . '/cookie.txt';
    $home_url = 'https://www.cndns.com/members/signin.aspx';
    $ch=curl_init($home_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_exec($ch);
    curl_close($ch);
}
function getImg(){
    $verify_code_url = "https://www.cndns.com/common/GenerateCheckCode.aspx?t=sign";
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
getImg();
?>
<html>
<head>
    <title>PHP cURL 模拟美橙互联登录</title>
    <meta charset="utf-8">
</head>
<body>
<form method="post">
    <div>美橙互联登录邮箱/手机号：<input type="text" name="user" value="694629075@qq.com"></div>
    <div>美橙互联登录密码：<input type="password" name="password" value="psk775521."></div>
    <div>美橙互联登录验证码：<input type="text" name="code"><img src="verifyCode.jpg" alt=""   id='img'></div>
    <div><input type="submit" value="提交"></div>
</form>
</body>
</html>


