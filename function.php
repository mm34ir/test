<?php
header('Content-Type: application/json');
function furl($url){
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
function match($match,$su,$ss=1){
    preg_match($match,$su,$sp);
    return $sp[$ss];
}
function match_all($match,$su,$ss=1,$ne=0){
    preg_match_all($match,$su,$sp);
    return $sp[$ss][$ne];
}
function jsen($data){
    return json_encode($data, (JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}
function jsde($data,$var=true){
    return json_decode($data,$var);   
}
function calculator($textbox){
            //  Preg_match function to match the patern and express the result
            if(preg_match('/(?:\-?[0-9]+(?:\.?[0-9]+)?[\+\-\*\/]+)+\-?[0-9]+(?:\.?[0-9]+)?/', $textbox, $matchpattern)){
                // need faddition function
                return faddition($matchpattern[0]);
            }
            return 0;
        
        return $textbox;
    }
function faddition($textbox){
        $n = create_function(' ', 'return '.$textbox.';');
        return $n();
    }
function realFilename($url){
   $headers      = get_headers($url, 1);
   $headers      = array_change_key_case($headers, CASE_LOWER);
   $realfilename = '';
 
   if(isset($headers['content-disposition'])) 
      {
         $tmp_name = explode('=', $headers['content-disposition']);
         if($tmp_name[1]) 
            {
               $realfilename = trim($tmp_name[1], '";\'');
            }
      } 
   else  
      { 
         $info         = pathinfo($url);
         if(isset($info['extension']))
            {
               $realfilename = $info['filename'].'.'.$info['extension']; 
            }
      } 
 
  return $realfilename;
}
function unzip($file,$path){
     $zip = new ZipArchive;  
     $res = $zip->open($file);  
     if ($res === TRUE) {  
         $zip->extractTo($path.'/');  
         $zip->close();  
         return 'ok';  
     } else {  
         return 'failed';  
     }  
}
