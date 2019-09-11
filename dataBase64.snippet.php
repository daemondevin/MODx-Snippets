<?php
/**
 * dataBase64
 * 
 * A Snippet to generate a data uri from a file 
 * 
 * NOTE: Call this Snippet non-cacheable to ensure 
 * your data-uris are always generated with the 
 * current page requests.
 */


$contents = $modx->getOption('contents',$scriptProperties,'');
$mime     = $modx->getOption('type',$scriptProperties,'');
$content  = file_get_contents($contents);
$base64   = base64_encode($content);
$output   = "data:$mime;base64,$base64";

return $output;
