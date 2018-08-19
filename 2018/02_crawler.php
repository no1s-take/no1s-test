<?php

$list = [];

function crawler($url)
{
    global $list;
    $tmp = [];
    $dom = new DOMDocument();
    @$dom->loadHTMLFile($url);
    $xpath = new DOMXPath($dom);

    if($xpath->document->doctype){
        $list[$url] = trim($xpath->evaluate('string(//title)'));
        $a_tags = $xpath->query('//a[starts-with(@href, "https://no1s.biz/")
            and not(contains(@href, ".jpg")) and not(contains(@href, ".png")) and not(contains(@href, ".gif"))
            and not(contains(@href, ".css")) and not(contains(@href, ".js"))]');
        foreach($a_tags as $a_tag){
            if(!array_key_exists($a_tag->getAttribute('href'), $list)){
                $tmp[$a_tag->getAttribute('href')] = null;
            }
        }
        if(isset($tmp)){
            $list += $tmp;
            foreach($tmp as $ur => $title){
                if(!$list[$ur]){
                    crawler($ur);
                }
            }
        }
    }
    else{
        $list[$url] = "このURLは存在しません";
    }
}

crawler("https://no1s.biz/");

ksort($list);
foreach($list as $url => $title){
    echo $url . "  " . $title . "\n";
}