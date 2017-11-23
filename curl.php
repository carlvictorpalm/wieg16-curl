<?php

$fileName = "homepage.html";
$ch = curl_init("http://www.catipsum.com/");
$fp = fopen("$fileName", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);

$words = [
    'cat' => 0,
    'ipsum' => 0,
];

$content = file_get_contents($fileName);
$content = strip_tags($content);
$content = explode(" ", $content);

foreach ($words as $word => $amount) {
    foreach($content as $line) {
        if(strpos($line, $word) !== false) {
            $words[$word] = $words[$word] + 1;
        }
    }
}
var_dump($content);