<?php
ob_start();
define('API_KEY','434009535:AAHtY9QtYKhtLUECJWJqlwkrLNuYY18r9ls');
$ch = '-1001303338365';
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
			            'caption'=>$text,
			            'reply_markup'=>json_encode([
			                'inline_keyboard'=>[
			                    [['text'=>'in Twitter','url'=>$text1]]
			                    ]
			                ])
			            ]);
			}
			elseif($type == "image"){
			        bot('sendphoto',[
			            'chat_id'=>$ch,
			            'photo'=>$urlmm,
			            'caption'=>$text,
			            'reply_markup'=>json_encode([
			                'inline_keyboard'=>[
			                    [['text'=>'in Twitter','url'=>$text1]]
			                    ]
			                ])
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
			            'text'=>$text,
			            'reply_markup'=>json_encode([
			                'inline_keyboard'=>[
			                    [['text'=>'in Twitter','url'=>$text1]]
			                    ]
			                ])
			            ]);
			}
			else{
			    bot('sendmessage',[
			     'chat_id'=>$ch,
			     'text'=>$text,
			            'reply_markup'=>json_encode([
			                'inline_keyboard'=>[
			                    [['text'=>'in Twitter','url'=>$text1]]
			                    ]
			                ])
			     ]);
			}
		}
