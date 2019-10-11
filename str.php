<?php

$string = $_SERVER["QUERY_STRING"];


$last_word_start = strrpos($string, ' ') + 5; 


$last_word = substr($string, $last_word_start); 


$name = str_replace('-', '_', $last_word);


$look = preg_replace("/\d+$/","",$last_word);


$nama = str_replace('&&id=', '', $look);

?>