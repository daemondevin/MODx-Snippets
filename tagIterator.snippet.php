<?php
/**
 * tagIterator
 *
 * Takes a HTML tag and returns it's markup however many times given
 * by the first passed parameter. This modifier expects 4 parameters
 * which are as follows:
 *
 * &iterate     integer     How many times the markup needs to be
 * &tag         string      The HTML tag
 * &class       string      The CSS class selector for the HTML tag
 * &inner       string      The innerHTML to use between the tags
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    PortableAppz.x10.mx/
 * @version 1.0
 */

$output = '';

$iterate    = $modx->getOption('iterate',$scriptProperties,'');
$tag        = $modx->getOption('tag',$scriptProperties,'');
$class      = $modx->getOption('class',$scriptProperties,'');
$inner      = $modx->getOption('inner',$scriptProperties,'');
$ctag       = $modx->getOption('closetag',$scriptProperties,true);


if ($ctag === true) {
    for($i = 1; $i <= $iterate; $i++) {
        $output .= "<{$tag} class=\"{$class}\">{$inner}</{$tag}>" . PHP_EOL;
    }
} else {
    for($i = 1; $i <= $iterate; $i++) {
        $output .= "<{$tag} class=\"{$class}\" {$inner}>" . PHP_EOL;
    }
}

return $output;
