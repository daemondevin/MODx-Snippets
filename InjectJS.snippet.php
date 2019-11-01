<?php
/**
 * InjectJS.
 *
 * Register JS to be injected inside the HEAD tag or just
 * before the closing BODY tag of a resource. Can be used
 * as an output modifier or ran as a snippet call.
 * This modifier expects the following parameters:
 * which are as follows:
 *
 * &mod       boolean   If false, will run as a snippet call.
 * &js        string    The JS to inject into the resource.
 * &startup   boolean   If true, injects the JS between the
 *                      HEAD tags, default is false which will
 *                      insert the JS just before the closing
 *                      BODY tag.
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$mod      = (boolean) $modx->getOption('mod',$scriptProperties,true);
$js       = (string)  $modx->getOption('js',$scriptProperties,null);
$startup  = (boolean) $modx->getOption('startup',$scriptProperties,false);

$output = $mod === 'true' ? $input : $js;

$startup === 'true' ? $modx->regClientStartupScript($output) : $modx->regClientScript($output);

return;
