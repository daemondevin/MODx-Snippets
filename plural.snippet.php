<?php
/**
 * plural
 *
 * @author     daemon.devin
 * @link       PortableAppz.x10.mx/
 * @copyright  2019
 * @version    1.0
 * 
 * This snippet takes a string and switches between the singular or plural form of a word
 * depending on the input number being greater the 1. 
 * 
 * This snippet also doubles an input modifier for words ending in 's'
 * 
 * NOTE: If calling this as a snippet and not a input modifier, you must set &mod to false!
 *
 * EXAMPLE #1
 * Show how many comments or "replies" you have for a post
 * You need to set &modifier=false if calling this snippet
 * 
 * [[plural?
 *     &modifier=`false`
 *     &integer=`[[+commentCount]]` 
 *     &word=`repl` 
 *     &singular=`y` 
 *     &plural=`ies`
 * ]]
 * 
 * The above snippet call will output the following: 
 * "0 replies" or "1 reply" or "2 replies" and so on
 *
 * EXAMPLE #2
 * Use as an input modifier like the following:
 * 
 * [[+clickCount:plural=`hit`]]
 * 
 * Where [[+clickCount]] is a number repersenting 
 * how many times a link has been clicked on.
 * This'll output something similar to:
 * "0 hits" or "1 hit" or "2 hits" and so on
 * 
 */

$modifier = $modx->getOption('modifier',$scriptProperties,true);

$output = "";

if ($modifier === true) {
    $input === 1 ? $output = $input . $options : $output = 's';
} else {
		$word     = $modx->getOption('word',$scriptProperties,'');
		$plural   = $modx->getOption('plural',$scriptProperties,'');
		$integer  = $modx->getOption('integer',$scriptProperties,'');
		$singular = $modx->getOption('singular',$scriptProperties,'');
    	
    $output   .= $integer;
    $output   .= ' '.$word; 
    $output   .= ($integer === 1 ? $singular : $plural);
}
return $output;
