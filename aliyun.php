<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/19
 * Time: 13:25
 */

//阿里云接口模拟请求
class Ali{

    private $method = 'GET';
    private $domain =  'http://domain.aliyuncs.com/?';
    private $region =  'http://ecs.aliyuncs.com/?';
    private $access_key = 'LTAI4FnTMrV8yHcM3V3BNKwc';
    private $secret_key = '4M4B0t9enaq9pKNb2eucJ5ZVfNzsNI';
    private $action_DescribeRegions = 'DescribeRegions';
    private $action_CheckDomain = 'CheckDomain';
    private $action_SaveSingleTaskForCreatingOrderActivate = 'SaveSingleTaskForCreatingOrderActivate';
    private $formate = 'json';
    private $hash_mehtod = 'HMAC-SHA1';
    private $signatureVersion = '1.0';
    //获取测试服务器源
    public function getDescribeRegions()
    {
        $Timestamp = $this->getTimeStamp();
        $action = $this->action_DescribeRegions;
        $accessKeyId = $this->access_key;
        $signatureMethod = $this->hash_mehtod;
        $signatureVersion = $this->signatureVersion;
        $signatureNonce = $this->getRandStr(6,1);
        $version = '2014-05-26';
        $format = $this->formate;
        $secret_key = $this->secret_key;
        $public =
            [
                'Action'    =>  $action,
                'AccessKeyId'   =>  $accessKeyId,
                'SignatureMethod'   =>  $signatureMethod,
                'SignatureVersion'  =>  $signatureVersion,
                'SignatureNonce'    =>  $signatureNonce,
                'Timestamp' =>  $Timestamp,
                'Version' =>    $version,
                'Format'    =>  $format
            ];
        ksort($public);
        $arr = [];
        foreach ($public as $key => $val)
        {
            $arr[] = $this->percentEncode($key).'='.$this->percentEncode($val);
        }
        $str = join('&',$arr);
        $stringToSign = $this->getStringToSign($str);
        $signature =$this->getSignature($stringToSign,$secret_key);
        $url =  $this->region.$str.'&Signature='.$signature;
        $res = $this->CurlGetInfo($url);
        print_r($res);
    }


    //检测域名是否可用
    public function getCheckDomain($name)
    {
        $Timestamp = $this->getTimeStamp();
        $action = $this->action_CheckDomain;
        $accessKeyId = $this->access_key;
        $signatureMethod = $this->hash_mehtod;
        $signatureVersion = $this->signatureVersion;
        $signatureNonce = $this->getRandStr(6,1);
        $version = '2018-01-29';
        $format = $this->formate;
        $secret_key = $this->secret_key;
        $public =
            [
                'Action'    =>  $action,
                'DomainName'    =>  $name,
                'AccessKeyId'   =>  $accessKeyId,
                'SignatureMethod'   =>  $signatureMethod,
                'SignatureVersion'  =>  $signatureVersion,
                'SignatureNonce'    =>  $signatureNonce,
                'Timestamp' =>  $Timestamp,
                'Version' =>    $version,
                'Format'    =>  $format
            ];
        ksort($public);
        $arr = [];
        foreach ($public as $key => $val)
        {
            $arr[] = $this->percentEncode($key).'='.$this->percentEncode($val);
        }
        $str = join('&',$arr);
        $stringToSign = $this->getStringToSign($str);
        $signature =$this->getSignature($stringToSign,$secret_key);
        $url =  $this->domain.$str.'&Signature='.$signature;
        $res = $this->CurlGetInfo($url);
        $res_str = '当前域名:'.$res['DomainName'].' 状态是:'.$this->getAvail($res['Avail']);
       return $res_str;
    }

    //保存域名信息
    public function getSaveSingleTaskForCreatingOrderActivate($name)
    {
        $Timestamp = $this->getTimeStamp();
        $action = $this->action_SaveSingleTaskForCreatingOrderActivate;
        $accessKeyId = $this->access_key;
        $signatureMethod = $this->hash_mehtod;
        $signatureVersion = $this->signatureVersion;
        $signatureNonce = $this->getRandStr(6,1);
        $version = '2018-01-29';
        $format = $this->formate;
        $secret_key = $this->secret_key;
        $public =
            [
                'Action'    =>  $action,
                'DomainName'    =>  $name,
                'AccessKeyId'   =>  $accessKeyId,
                'SignatureMethod'   =>  $signatureMethod,
                'SignatureVersion'  =>  $signatureVersion,
                'SignatureNonce'    =>  $signatureNonce,
                'Timestamp' =>  $Timestamp,
                'Version' =>    $version,
                'Format'    =>  $format
            ];
        ksort($public);
        $arr = [];
        foreach ($public as $key => $val)
        {
            $arr[] = $this->percentEncode($key).'='.$this->percentEncode($val);
        }
        $str = join('&',$arr);
        $stringToSign = $this->getStringToSign($str);
        $signature =$this->getSignature($stringToSign,$secret_key);
        $url =  $this->domain.$str.'&Signature='.$signature;
        $res = $this->CurlGetInfo($url);
        print_r($res);
    }

    //获取时间戳
    private function getTimeStamp(){
        date_default_timezone_set("GMT");
        return date('Y-m-d\TH:i:s\Z',time());
    }

    //获取状态显示的字符串
    private function getAvail($avail){
        $str = '';
        switch ($avail){
            case  0:
                $str = '不可注册';
                break;
            case 1:
                $str = '可注册';
                break;
            case  3:
                $str = '预登记';
                break;
            case  4:
                $str = '可删除预订';
                break;
            case  -1:
                $str = '异常';
                break;
            case  -2:
                $str = '暂停注册';
                break;
            case  -3:
                $str = '黑名单';
                break;
        }
        return $str;
    }

    //curl 获取接口返回的信息
    private function CurlGetInfo($url){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        curl_close($curl);
        return json_decode($tmpInfo,true);
    }

    //获取随机字符串
    private function getRandStr($length,$num = 0)
    {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if($num == 1)
        {
            $str = '0123456789';
        }
        $len = strlen($str)-1;
        $rand_str = '';
        for($i = 0 ;$i < $length ;++$i)
        {
            $num = mt_rand(0,$len);
            $rand_str .=$str[$num];
        }
        return $rand_str;
    }

    //转化字符
    private  function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    //返回签名信息
    private function getSignature($stringToSign,$secret_key){
        return  base64_encode(hash_hmac('sha1',utf8_encode($stringToSign),$secret_key.'&',true));;
    }

    //返回待签名的数据
    private function getStringToSign($str){
        return $this->method.'&%2F&'.$this->percentEncode($str);
    }
}
if(!empty($_POST['domain'])) {
    $ali = new Ali;
    echo "正在检查域名状态,请稍后……"."<br/>";
    sleep(2);
    $str = $ali->getCheckDomain($_POST['domain']);
    echo $str."<br/>";
    echo "正在注册域名,请稍后……"."<br/>";
    sleep(2);
    $res = $ali->getSaveSingleTaskForCreatingOrderActivate($_POST['domain']);
    print_r($res)."<br/>";
    exit;
}
?>
<html>
<head>
    <title>PHP cURL 模拟阿里云域名注册</title>
    <meta charset="utf-8">
</head>
<body>
<form method="post">
    <div>阿里云域名：<input type="text" name="domain" value=""></div>
    <div><input type="submit" value="提交"></div>
</form>
</body>
</html>
