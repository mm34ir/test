<?php
ob_start();
//token ro inja vared konid
header('Content-Type: application/json');
define('API_KEY','740467555:AAFFliqQiLltnV2i3Ek3KNnmCu1EZ_CkuDI');
$ADMIN = 399130642;
$pc = '-1001127647729';
//echo file_get_contents('https://api.telegram.org/bot'.API_KEY.'/setwebhook?url='.$_SERVER["SCRIPT_URI"]);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$text1 = $_GET['url'];
if(preg_match('/twitter\.com/', $text1)){
		$apilink="http://parsigig.me/api/twitter/?url==$text1";
		$json=json_decode(file_get_contents($apilink),true);
		$ok=$json['ok'];
		$type = $json["result"]["type"];
		$urlmm = $json["result"]["url"];
		$text = $json["result"]["text"];
		if($type =="video"){
			        bot('sendVideo',[
			            'chat_id'=>-1001463293916,
			            'video'=>$urlmm,
			            'caption'=>$text
			            ]);
			}
			elseif($type == "image"){
			        bot('sendphoto',[
			            'chat_id'=>-1001463293916,
			            'photo'=>$urlmm,
			            'caption'=>$text
			            ]);
			}elseif($type == "image slide"){
			    for($i=0;$i<count($urlmm);$i++){
			        bot('sendphoto',[
			            'chat_id'=>-1001463293916,
			            'photo'=>$urlmm[$i]['url']
			            ]);
			    }
			    bot('sendmessage',[
			            'chat_id'=>-1001463293916,
			            'text'=>$text
			            ]);
			}
			else{
			    bot('sendmessage',[
			     'chat_id'=>-1001463293916,
			     'text'=>$text
			     ]);
			}
		}
if(preg_match('/tumblr\.com/', $text1)){
preg_match('/http[sS]?:\/\/(.*?tumblr.com)\/post\/(\d+)\/?/m',$text1,$rm);
$ur = json_decode(file_get_contents('https://api.tumblr.com/v2/blog/'.$rm[1].'/posts?id='.$rm[2].'&api_key=XWllDtiaeH4rIfzTGFOryYadgaLfCjVWIHKAhXx9xKXUKSYq6t'),true);
$typ = $ur['response']['posts'][0]['type'];
if($typ =='photo'){
$url = $ur['response']['posts'][0]['photos'];

    foreach($url as $rr){
        if(preg_match('/gif/',$rr['original_size']['url'])){
        $xm = bot('sendvideo',[
        'chat_id'=> -1001127647729,
        'video'=>$rr['original_size']['url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
        }
        else{
        $xm = bot('sendphoto',[
        'chat_id'=> -1001127647729,
        'photo'=>$rr['original_size']['url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
    }
    }
}elseif($typ =='video'){
    bot('sendvideo',[
        'chat_id'=> -1001127647729,
        'video'=>$ur['response']['posts'][0]['video_url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
}elseif($typ == 'text'){
    $js = $file['response']['posts'][0]['body'];
if(preg_match('/<p>(.*?)<\/p>/s',$js,$cp)){
    $cap = $cp[1];
}
print_r($js);
if(preg_match('/<img src="(.*?.gif)" /m',$js)){
    preg_match_all('/<img src="(.*?.gif)" /m',$js,$sc);
    print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendvideo',[
            'chat_id'=>-1001127647729,
            'video'=>$ss,
            'caption'=>$cap
        ]);
    }
}
if(preg_match('/<img src="(.*?.(jpg|png))" /m',$js)){
    preg_match_all('/<img src="(.*?.(jpg|png))" /m',$js,$sc);
    print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendphoto',[
            'chat_id'=>-1001127647729,
            'photo'=>$ss,
            'caption'=>$cap
        ]);
    }
}if(preg_match('/"media":{"url":"(.*?mp4)","type":"video\/mp4"/m',$js)){
    preg_match_all('/"media":{"url":"(.*?mp4)","type":"video\/mp4"/m',$js,$sc);
    print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendvideo',[
            'chat_id'=>-1001127647729,
            'video'=>$ss,
            'caption'=>$cap
        ]);
    }
}else{
    bot('sendmessage',[
        'chat_id'=>-1001127647729,
        'text'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
    ]);
}
}
}
