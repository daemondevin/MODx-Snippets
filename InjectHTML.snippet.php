<?php
/**
 * InjectHTML
 *
 * Register HTML to be injected inside the HEAD tag or just
 * before the closing BODY tag of a resource. Can be used
 * as an output modifier or ran as a snippet call.
 * This modifier expects the following parameters:
 * which are as follows:
 *
 * &mod       boolean   If false, will run as a snippet call.
 * &html      string    The html to inject into the resource.
 * &startup   boolean   If true, injects the HTML between the
 *                      HEAD tags, default is false which will
 *                      insert the HTML just before the closing
 *                      BODY tag.
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$mod      = (boolean) $modx->getOption('mod',$scriptProperties,true);
$html     = (string)  $modx->getOption('html',$scriptProperties,null);
$startup  = (boolean) $modx->getOption('startup',$scriptProperties,false);

$output = $mod === 'true' ? htmlentities($input) : htmlentities($html);

$output = html_entity_decode($output);

if ($startup === false) {
  $modx->regClientHTMLBlock("\n$output\n");
} else {
  $modx->regClientStartupHTMLBlock("\n$output\n");
}
return;
