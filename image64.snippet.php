<?php
/**
 * image64
 *
 * @author     demon.devin
 * @link       Softables.tk/
 * @copyright  2017
 * @package    image64
 * @version    1.0
 * 
 * PROPERTIES
 * &alt       string   optional    What to display in the alt attribute
 * &img       string   required    path to desired image file
 * &css       boolean  required    if true will return just the data encoding. if false will return an img tag.
 * &extra     string   optional    specify any other attributes you'd like here. Example: data-user-attribute="something"
 *
 * EXAMPLE - For use within a css file or within <style></style> tags :
 * background: url("[[!image64? &img=`img/php.png` &css=`true`]]") no-repeat left 2px;
 * 
 * OUTPUT : background: url("data:image/png;base64,<!--BASE64 ENCODING HERE-->") no-repeat left 2px;
 * 
 * EXAMPLE - For use within an img tag :
 * [[!image64? &img=`img/avatar.png` &alt=`demon.devin's Avatar`]]
 * 
 * OUTPUT :<img src="data:image/png;base64,<!--BASE64 ENCODING HERE-->" alt="demon.devin's Avatar" />
 * 
 * EXAMPLE - With &extra=`` property :
 * [[!image64? &img=`img/avatar.png` &extra=`title="demon.devin's Avatar" data-attr="user-image"`]]
 * 
 * OUTPUT:
 * <img src="data:image/png;base64,<!--BASE64 ENCODING HERE-->"" title="demon.devin's Avatar" data-attr="user-image" />
 *
 */
$alt = $modx->getOption('alt',$scriptProperties,'');
$img = $modx->getOption('img',$scriptProperties,null);
$css = $modx->getOption('css',$scriptProperties,false);
$title = $modx->getOption('title',$scriptProperties,'');
$extra = $modx->getOption('extra',$scriptProperties,'');

$output = '';

if(is_null($img) || !file_exists($img)) {
	
	$modx->log(modX::LOG_LEVEL_ERROR, '[image64] Specified image ('.$img.') is null or doesn\'t exist!');
	$output = "[image64] Specified image ($img) is null or doesn't exist.";

} else {
	
	$src = base64_encode(file_get_contents($img));
	$img64 = 'data:'.mime_content_type($img).';base64,'.$src;
	if($css){
		$output = $img64;
	} else {
		$output  = "<img src=\"$img64\" ";
		if(!empty($alt)){$output .= "alt=\"$alt\" ";}
		if(!empty($title)){$output .= "title=\"$title\" ";}
		if(!empty($extra)){$output .= "$extra ";}
		$output .= "/>";
	}
	
}

return $output;
