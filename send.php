<?php
ob_start();
header('Content-Type: application/json');
define('API_KEY','Your Token');
$ch = 'Channel id';
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
			            'chat_id'=>$ch,
			            'video'=>$urlmm,
			            'caption'=>$text
			            ]);
			}
			elseif($type == "image"){
			        bot('sendphoto',[
			            'chat_id'=>$ch,
			            'photo'=>$urlmm,
			            'caption'=>$text
			            ]);
			}elseif($type == "image slide"){
			    for($i=0;$i<count($urlmm);$i++){
			        bot('sendphoto',[
			            'chat_id'=>$ch,
			            'photo'=>$urlmm[$i]['url']
			            ]);
			    }
			    bot('sendmessage',[
			            'chat_id'=>$ch,
			            'text'=>$text
			            ]);
			}
			else{
			    bot('sendmessage',[
			     'chat_id'=>$ch,
			     'text'=>$text
			     ]);
			}
		}
