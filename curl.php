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

foreach ($words as $word => $amount) {
  $words[$word] = substr_count($content, $word);
}
var_dump($words);
