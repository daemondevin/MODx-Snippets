<?php
/**
 * PHP's answer to Java's removeCharAt() function.
 * Can be used as an output modifier or called as a snippet.
 */

$output = "";

$mod = $modx->getOption('mod',$scriptProperties,1);

if ($mod === 1) {
		$str = $input;
		$int = $options;
} else {
	if ($mod === 0) {
		$str = $modx->getOption('str',$scriptProperties,'');
		$int = $modx->getOption('int',$scriptProperties,'');
	}
}

$output = substr_replace($str,"",$int,1);

return $output;
