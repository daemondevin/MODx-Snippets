<?php
/**
 * anchor
 * 
 * A Snippet to generate proper anchor tags which respect 
 * current request parameters.
 * 
 * NOTE: Call this Snippet non-cacheable to ensure your 
 * anchor tags are always generated with the current query 
 * string parameters.
 */
 
$anchor = $modx->getOption('anchor',$scriptProperties,'');
$title = $modx->getOption('title',$scriptProperties,'');
$link = $modx->getOption('link',$scriptProperties,'');
$cls = $modx->getOption('cls',$scriptProperties,''); 
$output = '';
$scheme = !isset($scheme) || $scheme === '' ? $modx->getOption('link_tag_scheme', $scriptProperties, 'full') : $scheme;

$resourceId = $modx->resource->get('id');
$queryString = $modx->request->getParameters();

$url = $modx->makeUrl($resourceId, '', modX::toQueryString($queryString), $scheme) . '#' . urlencode(strtolower($anchor));

$output  = '<a name="'.urlencode(strtolower($anchor)).'" ';
if(!empty($cls)) {
	$output .= 'class="'.$cls.'"';
}
if(!empty($link) && $link != false) {
	$output .= 'href="'. $url .'">'. (empty($title)?ucfirst($anchor):ucfirst($title)) .'</a>';
} else { 
	$output .= '>'. (empty($title)?ucfirst($anchor):ucfirst($title)) .'</a>';
}
return $output;
