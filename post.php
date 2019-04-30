<?php
ob_start();
//token ro inja vared konid
//header('Content-Type: application/json');
define('API_KEY','XXXXX:XXXXXXXXX');
$pc = 'XXXXXXXXXXXXXXX';
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
$text1 = $_POST['name'];
if(isset($text1)){
if(preg_match('/twitter\.com/', $text1)){
		$apilink="http://parsigig.me/api/twitter/?url==$text1";
		$json=json_decode(file_get_contents($apilink),true);
		$ok=$json['ok'];
		$type = $json["result"]["type"];
		$urlmm = $json["result"]["url"];
		$text = $json["result"]["text"];
		if($type =="video"){
			        bot('sendVideo',[
			            'chat_id'=>$pc,
			            'video'=>$urlmm,
			            'caption'=>$text
			            ]);
			}
			elseif($type == "image"){
			        bot('sendphoto',[
			            'chat_id'=>$pc,
			            'photo'=>$urlmm,
			            'caption'=>$text
			            ]);
			}elseif($type == "image slide"){
			    for($i=0;$i<count($urlmm);$i++){
			        bot('sendphoto',[
			            'chat_id'=>$pc,
			            'photo'=>$urlmm[$i]['url']
			            ]);
			    }
			    bot('sendmessage',[
			            'chat_id'=>$pc,
			            'text'=>$text
			            ]);
			}
			else{
			    bot('sendmessage',[
			     'chat_id'=>$pc,
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
        'chat_id'=> $pc,
        'video'=>$rr['original_size']['url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
        }
        else{
        $xm = bot('sendphoto',[
        'chat_id'=> $pc,
        'photo'=>$rr['original_size']['url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
    }
    }
}elseif($typ =='video'){
    bot('sendvideo',[
        'chat_id'=> $pc,
        'video'=>$ur['response']['posts'][0]['video_url'],
        'caption'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
        ]);
}elseif($typ == 'text'){
    $js = $ur['response']['posts'][0]['body'];
if(preg_match('/<p>(.*?)<\/p>/s',$js,$cp)){
    $cap = $cp[1];
}
//print_r($js);
if(preg_match('/<img src="(.*?.gif)" /m',$js)){
    preg_match_all('/<img src="(.*?.gif)" /m',$js,$sc);
    //print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendvideo',[
            'chat_id'=>$pc,
            'video'=>$ss,
            'caption'=>$cap
        ]);
    }
}
if(preg_match('/<img src=\\\\?"(.*?.jpg)\\\\?"/s',$js)){
    preg_match_all('/<img src=\\\\?"(.*?.jpg)\\\\?"/s',$js,$sc);
    //print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendphoto',[
            'chat_id'=>$pc,
            'photo'=>$ss,
            'caption'=>$cap
        ]);
    }
}if(preg_match('/"media":{"url":"(.*?mp4)","type":"video\/mp4"/m',$js)){
    preg_match_all('/"media":{"url":"(.*?mp4)","type":"video\/mp4"/m',$js,$sc);
    //print_r($sc);
    foreach($sc[1] as $ss){
        bot('sendvideo',[
            'chat_id'=>$pc,
            'video'=>$ss,
            'caption'=>$cap
        ]);
    }
}else{
    bot('sendmessage',[
        'chat_id'=>$pc,
        'text'=>$ur['response']['posts'][0]['summary'],
        'parse_mode'=>'html'
    ]);
}
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Twitter to RSS proxy</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="Twitter, RSS, Atom, feed, reader, agregator, convert to, convert, to">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style="padding: 20px;">
	<div class="container">
		<div class="jumbotron vertical-center">
			<div class="container">
				<h1>Twitter to Telegram
					<small>poster</small>
				</h1><br />
				<p>Enter Twitter post link to send in telegram !</p>
				<form id="tform" class="form-horizontal" role="form" action="index.php" method="POST">
					<div class="form-group">
						<div class="input-group input-group-lg">
							<input type="text" id="name" name="name" class="form-control search-query" placeholder="Twitter Address" required>
								<span class="input-group-btn">
									<input class="btn btn-primary" type="submit" value="Send To Telegram">
								</span>
						</div>
					</div>
				</form>
			</div>
		</div> <!-- jumbotron -->
		<footer class="navbar-fixed-bottom">
			<div style="text-align: center;"><p><a href="https://github.com/n0madic/twitter2rss">GitHub</a> &copy; Nomadic 2014-2017</p></div>
		</footer>
	</div>
</body>
</html>
