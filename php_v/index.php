<?php
header("Content-type: text/html; charset=utf-8"); 
//define your token
define("TOKEN", "weixin");//
$wechatObj = new wechat();
if
(isset($_GET['echostr']))
{
$wechatObj->valid();
}
else
{
$wechatObj->responseMsg();
}

class wechat
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //useful signature
        if
        ($this->checkSignature())
        {
        echo $echoStr;
        exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if
        ($tmpStr == $signature)
        {
        return true;
        }
        else
        {
        return false;
        }
    }

    public function responseMsg()
    //receive data
    {
        //use GET or POST according to the environment
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //recieve POST data
        if
        (!empty($postStr))
        {
        //use SimpleXML decode posted XML data
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $type = trim($postObj -> MsgType);
        
            //判断数据类型
            switch
            ($type)
            {
            case "text":
                $resultStr = $this -> receiveText($postObj);
                break;
            case "event":
                $resultStr = $this -> receiveEvent($postObj);
                break;
            default:
                $resultStr = "unknow msg type: ".$type;
                break;
            }
        echo $resultStr;//return result
        }
        else
        {
        echo "";
        exit;
        }
    }

    private function receiveText($object)
    {
        
        $funcFlag = 0;
        $keyword = trim($object->Content);//recieve message's content
        $resultStr = "";
        $contentStr = "";
        //return data
        //set reply key word
        
        if
        (mb_substr($keyword,0,4,'utf-8') == "大众点评")
        {
        $keyword_len = mb_strlen($keyword,'utf-8');
        $str_keyword = mb_substr($keyword,5,$keyword_len-5,'utf-8');
        
            //need PHP that's version higher than 5 and expansion of curl

//AppKey (Attension, this data is a secret of my wechat official account, so I use '*' instead)
define('APPKEY','*');

//AppSecret (Attension, this data is a secret of my wechat official account, so I use '*' instead)
define('SECRET','*');


//API request address
define('URL', 'http://api.dianping.com/v1/business/find_businesses');

//sample of request
$params = array('format'=>'json','city'=>'北京','sort'=>'3','category'=>'美食','limit'=>'1','keyword'=>$str_keyword);

//sort by parameters
ksort($params);
//print($params);

//link string waiting for Encryption
$codes = APPKEY;

//request URL parameter
$queryString = '';

while (list($key, $val) = each($params))
{
  $codes .=($key.$val);
  $queryString .=('&'.$key.'='.urlencode($val));
}

$codes .=SECRET;
//print($codes);

$sign = strtoupper(sha1($codes));

$url= URL . '?appkey='.APPKEY.'&sign='.$sign.$queryString;

$curl = curl_init();

// set URL
curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');

// runcURL，request API
$data = json_decode(curl_exec($curl), true);

// close url
curl_close($curl);



$title = $str_keyword;

$picUrl = $data['businesses'][0]['photo_url'];

$desc = $data['businesses'][0]['deals'][0]['description'];

$url = $data['businesses'][0]['business_url'];
            
        $resultStr = $this -> transmitPicText($object, $title, $funcFlag,$desc, $picUrl, $url);
        return $resultStr;
        }
        
        if($keyword == "party" ||$keyword=="Party"||$keyword== "聚会")
        {
        $contentStr = '<a href="http://4.party1992.sinaapp.com/page1.php">点我进入设置,click me to set</a>';
        $resultStr = $this -> transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
        }
        
        if( $keyword == "?" || $keyword =="？")
        {
            $contentStr = date("Y-m-d H:i:s",time());
            $resultStr = $this -> transmitText($object, $contentStr, $funcFlag);          
            return $resultStr;
         }
        //Auto reply
        if(is_numeric($keyword))//Return result according to the room number
        {
        include 'conn_sql.php';
            $contentStr = " 房间号（room number）：".$keyword."\n";
    
     $sql_1="select * from party_data where room_num=$keyword and msg_type='1' and p_time_1='on'";
     $res = mysql_query($sql_1,$conn);
     echo $num_t1 = mysql_num_rows($res);
            
     $sql_2="select * from party_data where room_num=$keyword and msg_type='1' and p_time_2='on'";
     $res = mysql_query($sql_2,$conn);
     echo $num_t2 = mysql_num_rows($res);
            
     $sql_3="select * from party_data where room_num=$keyword and msg_type='1' and p_time_3='on'";
     $res = mysql_query($sql_3,$conn);
     echo $num_t3 = mysql_num_rows($res);
            
    echo $final_t = max($num_t1,$num_t2,$num_t3);
            
     $sql_4="select * from party_data where room_num=$keyword and msg_type='1' and p_add_1='on'";
     $res = mysql_query($sql_4,$conn);
     echo $num_a1 = mysql_num_rows($res);
            
     $sql_5="select * from party_data where room_num=$keyword and msg_type='1' and p_add_2='on'";
     $res = mysql_query($sql_5,$conn);
     echo $num_a2 = mysql_num_rows($res);
            
     $sql_6="select * from party_data where room_num=$keyword and msg_type='1' and p_add_3='on'";
     $res = mysql_query($sql_6,$conn);
     echo $num_a3 = mysql_num_rows($res);
            
     echo $final_a = max($num_a1,$num_a2,$num_a3);
            
      $sql_t1="select * from party_data where room_num=$keyword and msg_type='0'";
      $res=mysql_query($sql_t1,$conn);
      $obj=mysql_fetch_object($res);
                  
     if( $final_t == $num_t1)
     {    
       $contentStr.=" 时间(time)：".$obj->p_time_1."\n";
     
     }
     else if( $final_t == $num_t2)
     {
       $contentStr.=" 时间(time)：".$obj->p_time_2."\n";
     
     }
     else
    {
    $contentStr.=" 时间(time)：".$obj->p_time_3."\n";
      
     }
     
            
     if( $final_a == $num_a1 )
     {    
        $contentStr.=" 地点(address)：".$obj->p_add_1."\n";
     }
     else if( $final_a == $num_a2)
     {
        $contentStr.=" 地点(address)：".$obj->p_add_2."\n";
     }
     else
     {
         $contentStr.=" 地点(address)：".$obj->p_add_3."\n";
     };
    mysql_close($conn);
           
            
        $resultStr = $this -> transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
        }
        else 
        {
        $contentStr = 'welcome, start by send order such as "party" to me
感谢您关注谷西决开发的聚会助手/::)
这个我现在还是做着玩，没什么功能，不好意思了。
回复【聚会】开始设置
回复【大众点评-XXX】查询美食，例如 大众点评-海底捞
回复房间号四位数字查看结果
回复问号【？】查看时间';//return text content
        $resultStr = $this -> transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
        }
    }

    private function receiveEvent($object)
    {
    $contentStr = "";
        switch
        ($object -> Event)
        {
        case "subscribe":
            //Auto send welcome message if being followed
            $contentStr = 'welcome, start by send order such as "party" to me,欢迎关注谷西决开发的聚会助手。感谢您的关注/::)这个我现在还是做着玩，没什么功能，不好意思了。回复帮助看稍微具体点的介绍。';
            break;
        }
    $resultStr = $this -> transmitText($object, $contentStr);
    return $resultStr;
    }
    
    private function transmitText($object, $content, $flag = 0)
    {
    //text message reply's sample
    $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
                </xml>";
    //standardize the sample
    $resultStr = sprintf($textTpl, $object -> FromUserName, $object -> ToUserName, time(), $content, $flag);
    return $resultStr;
    }
    
    private function transmitPicText($object, $title, $flag = 0,$desc, $picUrl, $url)
    {
        //reply text and image message
        $textTp2 = "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[news]]></MsgType>
 <ArticleCount>1</ArticleCount>
 <Articles>
 <item>
 <Title><![CDATA[%s]]></Title>
 <Description><![CDATA[%s]]></Description>
 <PicUrl><![CDATA[%s]]></PicUrl>
 <Url><![CDATA[%s]]></Url>
 </item>
 </Articles>
 <FuncFlag>%d</FuncFlag>
 </xml>";
         //standardize the sample
//desc description of the picture
//picurl picture's address
// url directing address after click
    $resultStr = sprintf($textTp2, $object -> FromUserName, $object -> ToUserName, time(), $title , $desc, $picUrl , $url, $flag);
    return $resultStr;          
    }
}
?>
