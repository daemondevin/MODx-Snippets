<?php
/**
 * getDoctype snippet for getDoctype extra
 *
 * @author     daemon.devin
 * @link       PortableAppz.x10.mx/
 * @copyright  2016
 * @package    getDoctype
 * @version    1.0
 * 
 * With this snippet you will have the ability to display the DOCTYPE while sending the
 * correct headers with support for content type negotiation.
 * 
 * It also will correct itself for the W3C validator which does not send the correct Accept
 * header for XHTML documents.
 * 
 * Does NOT send XHTML 1.1 to browsers that wont accept application/xhtml+xml because the
 * snippet will make sure the browser groks XML before sending anything.
 * visit: labs/PHP/DOCTYPE.php#bug-fix for details and a link to the W3C XHTML for more
 * 
 * PROPERTIES
 * &doc       string   required    Defaults: XHTML
 * Either HTML or XHTML 
 * 
 * &type      string   optional    Defaults:  Strict
 * One of three chooses between Strict, Transitional, or Frameset
 * 
 * &ver       string   optional    Defaults: 1.1
 * For XHTML: 1.0 or 1.1 | For HTML5: 5
 * 
 * &charset   string   optional    Defaults: [[++modx_charset]]
 * 
 * &lang      string   optional    Defaults: [[++cultureKey]]
 * 
 * &s         string   optional    Defaults: ' '
 * Specify prefered indentation. Either '\t' (tab) or ' ' (whitespace) or any combination 
 *
 * EXAMPLE 
 * To specify html5 use the following:
 * [[!getDoctype? &doc=`html` &ver=`5`]]
 *
 * Output: 
 * <!DOCTYPE html>
 * <html lang="en">
 *  <head>
 *   <meta charset="UTF-8">
 *
 * To specify XHTML using Strict with version 1.1 use the following:
 * [[!getDoctype? &doc=`xhtml` &type=`strict` &ver=`1.1`]]
 *
 * NOTE: This sends the XML declaration before the DOCTYPE
 *       but this will put IE into quirks mode which we don't 
 *       want so it omits it for IE
 * 
 * Output: 
 * <?xml version="1.0" encoding="utf-8"?>
 * <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
 *  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
 * <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 *
 */

$doc     = $modx->getOption('doc', $scriptProperties, 'xhtml');
$type    = $modx->getOption('type', $scriptProperties, 'strict');
$ver     = $modx->getOption('ver', $scriptProperties, '1.1');
$charset = $modx->getOption('charset', $scriptProperties, $modx->getOption('modx_charset'));
$lang    = $modx->getOption('lang', $scriptProperties, $modx->getOption('cultureKey'));
$s       = $modx->getOption('indent', $scriptProperties, ' ');

$output  = '';

$media   = array('HTML' => 'text/html', 'XHTML' => 'application/xhtml+xml');

$doc     = strtoupper($doc);
$type    = strtolower($type);

$avail   = 'PUBLIC'; // or SYSTEM, but we're not going there yet

// begin FPI
$ISO     = '-'; // W3C is not ISO registered [or IETF for that matter]
$OID     = 'W3C'; // unique owner ID
$PTC     = 'DTD'; // the public text class

$PTD     = '';
$PCL     = 'EN'; // as far as I know the PCL is always English
$URI     = 'http://www.w3.org/TR/'; // DTDs are all under the Technical Reports (TR) branch @ W3C

$doc_top = '<html'; // what comes after the DOCTYPE of course
$meta    = '<meta ';

if($doc == 'HTML') {

	if($ver == '5') {

		$top = 'html';
		$media_type = $media['HTML'];
		$meta .= 'charset="'.strtoupper($charset).'" />';

	}
	else {

		$top = $doc;
		$media_type = $media[$doc];

		$PTD = $doc.' 4.01'; // we're only supporting HTML 4.01 here

		switch ($type) {

			case 'frameset':

				$PTD .= ' '.ucfirst($type);
				$URI .= 'html4/frameset.dtd';
				break;

			case 'transitional':

				$PTD .= ' '.ucfirst($type);
				$URI .= 'html4/loose.dtd';
				break;

			case 'strict':
			default:

				$URI .= 'html4/strict.dtd';
		}
		$meta .= "http-equiv=\"Content-Type\" content=\"$media_type; charset=".strtoupper($charset)."\">";
	}
	$doc_top .= ' lang="'.$lang.'">';


}
else {

	// must be xhtml then, but catch typos

	//if($doc != 'XHTML')
	$doc = 'XHTML';

	$top = 'html'; // remember XML is lowercase
	$doc_top .= ' xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$lang.'"';

	// return the correct media type header for this document,
	// but we should probably make sure the browser groks XML!

	// the W3C validator does not send the correct Accept header for this family of documents, sigh
	if(stristr($_SERVER['HTTP_USER_AGENT'], 'W3C_Validator')) $media_type = $media['XHTML'];
	else  $media_type = (stristr($_SERVER['HTTP_ACCEPT'], $media['XHTML']))?$media['XHTML']:$media['HTML'];

	// do NOT send XHTML 1.1 to browsers that don't accept application/xhtml+xml
	// see: labs/PHP/DOCTYPE.php#bug-fix for details and a link to the W3C XHTML
	// NOTES on this topic

	if($media_type == $media['HTML'] and $ver == '1.1') $ver = '1.0';

	if($ver == '1.1') {
		$PTD = implode(' ', array($doc, $ver));
		$URI .= 'xhtml11/DTD/xhtml11.dtd';
	}
	else {
		$PTD = implode(' ', array(
			$doc,
			'1.0',
			ucfirst($type)));
		$URI .= 'xhtml1/DTD/xhtml1-'.$type.'.dtd';

		// for backwards compatibilty

		$doc_top .= ' lang="'.$lang.'"';
	}

	$doc_top .= '>'; // close root XHTML tag

	// send HTTP header
	header('Content-type: '.$media_type.'; charset='.$charset);

	// send the XML declaration before the DOCTYPE, but this
	// will put IE into quirks mode which we don't want
	if(isset($_SERVER['HTTP_USER_AGENT']) && ((strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == false) || strpos($_SERVER['HTTP_USER_AGENT'],
		'Trident') == false)) {
		$output .= '<?xml version="1.0" encoding="'.$charset.'"?>'.PHP_EOL;
	}

	$meta .= "http-equiv=\"Content-Type\" content=\"$media_type; charset=".strtoupper($charset)."\" />";

}

$FPI = implode('//', array(
	$ISO,
	$OID,
	$PTC.' '.$PTD,
	$PCL));

if($doc == 'HTML' && $ver == '5') {
	$output .= '<!DOCTYPE '.$top.'>'.PHP_EOL;
	$output .= $doc_top.PHP_EOL;
	$output .= "$s<head>".PHP_EOL;
	$output .= "$s$s$meta".PHP_EOL;
}
else {
	$output .= "<!DOCTYPE $top $avail \"$FPI\" ".PHP_EOL."$s\"$URI\">".PHP_EOL."$doc_top".PHP_EOL."$s<head>".PHP_EOL."$s$s".
		$meta.PHP_EOL;
}
return $output;
