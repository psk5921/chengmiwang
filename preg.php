<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/19
 * Time: 14:47
 */
//正则匹配
//匹配规则
//声母包含bpmfdtnlgkhjqxrzcsywaoeiu
//声母 两声母 三声母 四声母 五声母W尾
//字母 两字母  三字母  四字母
//数字无04   四数无04 五数无04 六数无04 七数88尾无04
//数字带04 三数 四数 五数 六数 六数非0开无4
//杂米 两杂 三杂
class Preg_Filter{

    private static $str = '暂未匹配该域名格式';

    private function __construct()
    {

    }
    //初始化
    static function _init($str){
        if(!isset($str) || empty($str)){
            return false;
        }
        $method = get_class_methods(new static());
        if(count($method)>0){
            foreach ($method as $item){
                if($item == '__construct' || $item == '_init' || $item == 'getStr'){
                        continue;
                }else{
                    $res =  self::$item($str);
                    if($res){
                        break;
                    }
                }
            }
        }
        return true;
    }

    //获取信息提示
    public static function getStr(){
        return self::$str;
    }

    //两声母匹配
    public static  function twoConsonant($str){
        $count = preg_match('/(^[bpmfdtnlgkhjqxrzcsywaoeiu]{2})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //两声母匹配
        if($count>0){
            self::$str = '两声母匹配';
        }
        return !!$count;
    }

    //三声母匹配
    public static  function ThirdConsonant($str){
        $count = preg_match('/(^[bpmfdtnlgkhjqxrzcsywaoeiu]{3})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //三声母匹配
        if($count>0){
           self::$str = '三声母匹配';
        }
        return !!$count;
    }

    //四声母匹配
    public static  function FourConsonant($str){
        $count = preg_match('/(^[bpmfdtnlgkhjqxrzcsywaoeiu]{4})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //四声母匹配
        if($count>0){
           self::$str = '四声母匹配';
        }
        return !!$count;
    }

    //五声母W尾
    public static  function FiveWConsonant($str){
        $count = preg_match('/(^[bpmfdtnlgkhjqxrzcsywaoeiu]{4}w)\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //五声母W尾
        if($count>0){
           self::$str = '五声母W尾匹配';
        }
        return !!$count;
    }

    //两字母
    public static  function twoLetter($str){
        $count = preg_match('/(^[a-z]{2})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //两字母匹配
        if($count>0){
           self::$str = '两字母匹配';
        }
        return !!$count;
    }

    //三字母
    public static  function thirdLetter($str){
        $count = preg_match('/(^[a-z]{3})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //三字母匹配
        if($count>0){
           self::$str = '三字母匹配';
        }
        return !!$count;
    }

    //四字母
    public static  function FourLetter($str){
        $count = preg_match('/(^[a-z]{4})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //四字母匹配
        if($count>0){
           self::$str = '四字母匹配';
        }
        return !!$count;
    }


    //数字无04三数
    public static  function NumberNoFourForThree($str){
        $count = preg_match('/(^[12356789]{3})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字无04三数
        if($count>0){
           self::$str = '数字无04三数匹配';
        }
        return !!$count;
    }

    //数字无04四数
    public static  function NumberNoFourForFour($str){
        $count = preg_match('/(^[12356789]{4})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字无04四数
        if($count>0){
           self::$str = '数字无04四数匹配';
        }
        return !!$count;
    }

    //数字无04五数
    public static  function NumberNoFourForFive($str){
        $count = preg_match('/(^[12356789]{5})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字无04五数
        if($count>0){
           self::$str = '数字无04五数匹配';
        }
        return !!$count;
    }

    //数字无04六数
    public static  function NumberNoFourForSix($str){
        $count = preg_match('/(^[12356789]{6})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字无04六数
        if($count>0){
           self::$str = '数字无04六数匹配';
        }
        return !!$count;
    }

    //数字七数88尾无04
    public static  function NumberNoFourForSeven($str){
        $count = preg_match('/(^[12356789]{5}88)\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字七数88尾无04
        if($count>0){
           self::$str = '数字七数88尾无04匹配';
        }
        return !!$count;
    }

    //数字带04三数
    public static  function NumberHasFourForThree($str){
        $count = preg_match('/(^[0-9]{3})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字带04三数
        if($count>0){
           self::$str = '数字带04三数匹配';
        }
        return !!$count;
    }

    //数字带04四数
    public static  function NumberHasFourForFour($str){
        $count = preg_match('/(^[0-9]{4})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字带04四数
        if($count>0){
           self::$str = '数字带04四数匹配';
        }
        return !!$count;
    }

    //数字带04五数
    public static  function NumberHasFourForFive($str){
        $count = preg_match('/(^[0-9]{5})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字带04五数
        if($count>0){
           self::$str = '数字带04五数匹配';
        }
        return !!$count;
    }

    //数字带04六数
    public static  function NumberHasFourForSix($str){
        $count = preg_match('/(^[0-9]{6})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字无04六数
        if($count>0){
           self::$str = '数字带04六数匹配';
        }
        return !!$count;
    }

    //数字六数非0开无4
    public static  function NumberHasFourForSixZero($str){
        $count = preg_match('/([^0]{1}[012356789]{5})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //数字六数非0开无4
        if($count>0){
           self::$str = '数字六数非0开无4匹配';
        }
        return !!$count;
    }

    //两杂
    public static  function TwoMixed($str){
        $count = preg_match('/(^[a-z0-9]{2})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //两杂
        if($count>0){
           self::$str = '两杂匹配';
        }
        return !!$count;
    }

    //三杂
    public static  function ThirdMixed($str){
        $count = preg_match('/(^[a-z0-9]{3})\.[com|net|cn|cc|com.cn|org|wang|top|biz|vip|xin]+/',$str,$arr); //三杂
        if($count>0){
           self::$str = '三杂匹配';
        }
        return !!$count;
    }
}
if(!empty($_POST['domain'])) {
    $rt = Preg_Filter::_init($_POST['domain']);
    echo "正在分析域名品相,请稍后……"."<br/>";
    sleep(2);
    $str = Preg_Filter::getStr();
    echo '当前域名品相是:'.$str."<br/>";
    exit;
}
?>
<html>
<head>
    <title>PHP cURL 模拟分析域名品相</title>
    <meta charset="utf-8">
</head>
<body>
<form method="post">
    <div>输入域名地址：<input type="text" name="domain" value=""></div>
    <div><input type="submit" value="提交"></div>
</form>
</body>
</html>