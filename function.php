<?php
header('Content-Type: application/json');
function fileGetContentsCurl($url){
    $curl = curl_init();
    $agent = 'Mozilla/5.0 (Windows NT 6.1; rv:15.0) Gecko/20120716 Firefox/15.0a2';
    $header = array('Accept-Charset: UTF-8');
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 2);
    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3); 
    curl_setopt($curl, CURLOPT_URL, $url);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
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
