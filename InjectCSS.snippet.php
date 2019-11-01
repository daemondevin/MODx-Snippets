<?php
/**
 * InjectCSS.
 *
 * Register CSS to be injected inside the HEAD tag of a resource.
 * Can be used as an output modifier or ran as a snippet call.
 * This modifier expects the following parameters:
 * which are as follows:
 *
 * &mod   boolean   If false, will run as a snippet call.
 * &css   string    The CSS to inject into the resource's HEAD tag.
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$mod = (boolean) $modx->getOption('mod',$scriptProperties,'true');
$css = (string)  $modx->getOption('css',$scriptProperties,null);

$output = $mod === 'true' ? $input : $css;

$modx->regClientCSS($output);

return;
