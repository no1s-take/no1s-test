<?php
require "vendor/autoload.php";
use \Abraham\TwitterOAuth\TwitterOAuth;

$consumer_key        = ""; //CONSUMER_KEY
$consumer_secret     = "";  //CONSUMER_SECRET
$access_token        = "";  //ACCESS_TOKEN
$access_token_secret = "";  //ACCESS_TOKEN_SECRET

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");

$param = array(
    "q" => "JustinBieber filter:images -rt",
    "count" => 100,
    "result_type" => "recent",
    "include_entities" => true,
);

$statuses = $connection->get("search/tweets", $param);
if(isset($statuses->errors[0]->message)){
    echo "ERROR_MESSAGE:" . $statuses->errors[0]->message . "\n";
    echo "ERROR_CODE:" . $statuses->errors[0]->code;
    exit;
}

$list = [];
foreach($statuses->statuses as $i => $val){
    if(isset($val->entities->media[0]->media_url)){
        $list[] = $val->entities->media[0]->media_url;
    }
    if(count($list) >= 10){
        break;
    }
}

if(file_exists("./images")){
    if(is_dir("./images")){
        exec("rm -r ./images/*");
    }
}
else{
    exec("mkdir images");
}

foreach($list as $i => $val){
    $ext = strrchr($val, '.');
    exec("curl -o ./images/image" . ($i + 1) . $ext . " ". $val);
}