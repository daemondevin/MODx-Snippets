<?php
/**
 * hashEmail
 *
 * @author     demon.devin
 * @link       PortableAppz.cu.cc/
 * @copyright  2016
 * @package    hashEmail
 * @version    1.0
 * 
 * With this snippet you can encode any email address into its equivalent Unicode
 * decimal entity. This encoded email address will be read and translated back 
 * into its original, human readable form by the clients web browser. Converting 
 * your email address to unicode will allow you to protect your email address 
 * from spambots that search the internet for email addresses. 
 *
 * NOTE: This technique is not a foolproof solution! Any well established service
 * with software such as Google's&trade; search engine can still read your email 
 * address regardless. However this technique will still certainly go a long way 
 * towards minimizing your exposure to less capable automated email harvesters.
 *
 * PROPERTIES
 * &email  |  string  |  required  ->  the email you wish to be encoded.
 *
 * EXAMPLE:
 * Contact me: [[!hashEmail? &email=`example@dot.com`]]
 *
 * OUTPUT (page source):
 * Contact me: &#101;&#120;&#97;&#109;&#112;&#108;&#101;&#64;&#100;&#111;&#116;&#46;&#99;&#111;&#109;
 * 
 * OUTPUT (front end):
 * Contact me: example@dot.com
 * 
 * Can also be used within a mailto link.
 *
 * EXAMPLE:
 * <a href="mailto:[[!hashEmail? &email=`example@dot.com`]]">[[!hashEmail? &email=`example@dot.com`]]</a>
 *
 * OUTPUT (page source):
 * <a href="mailto:&#101;&#120;&#97;&#109;&#112;&#108;&#101;&#64;&#100;&#111;&#116;&#46;&#99;&#111;&#109;">
 * &#101;&#120;&#97;&#109;&#112;&#108;&#101;&#64;&#100;&#111;&#116;&#46;&#99;&#111;&#109;</a>
 *
 * OUTPUT (front end):
 * example@dot.com 
 *
 */

$email = $modx->getOption('email', $scriptProperties);

$pieces = str_split(trim($email));
$hashed = '';
foreach ($pieces as $val) {
    $hashed .= '&#'.ord($val).';';
}
return $hashed;
