<?php
/**
 * lastModified
 *
 * @author     demon.devin
 * @link       PortableAppz.cu.cc/
 * @copyright  2016
 * @package    lastMofified
 * @version    1.0
 * 
 * With this snippet you will have the ability to deliver the most recent version of any file. 
 * When dealing with a browser's cache you can't be certain your viewers are getting the most 
 * recent copy. By appending a GET value (the UNIX timestamp) to, for example, a stylesheet, 
 * you can make the browser think the stylesheet is dynamic, thus reloading the stylesheet time 
 * the modification date changes. 
 *
 * PROPERTIES
 * &path  |  string  |  required  ->  path to the file to download with trailing slash
 * &file  |  string  |  required  ->  filename of the document you wish to use
 *
 * EXAMPLE:
 * Specify a path &path=`css/` and the file &file=`style`. See OUTPUT below for example.
 * Don't for get to use a trailing slash on &path!
 *
 * <link rel="stylesheet" type="text/css" href="[[!lastModified? &path=`css/` &file='style.css']]" />
 *
 * OUTPUT:
 * <link rel="stylesheet" type="text/css" href="style.css?1477050530" />
 */
 
$path = $modx->getOption('path', $scriptProperties);
$file = $modx->getOption('file', $scriptProperties);

$lastModified = filemtime($path.$file);
$timeStamp = $path.$file.'?'.$lastModified;

return $timeStamp;
