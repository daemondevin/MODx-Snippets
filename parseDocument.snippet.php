<?php
/**
 * ParseDocument
 *
 * Grabs the contents of a document outside of MODx and 
 * returns it's parsed contents for MODx tags.
 *
 * &file     string   The file to parse for MODx tags.
 * &type     string   Choose between css, js, or html.
 * &startup  boolean  If true, injects the output just 
 *                    before the closing HEAD tag
 *
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$file    = $modx->getOption('file',$scriptProperties,null);
$type    = $modx->getOption('type',$scriptProperties,null);
$startup = $modx->getOption('startup',$scriptProperties,false);

$content = file_get_contents(MODX_BASE_PATH.$file);

$chunk = $modx->newObject('modChunk');
$chunk->setContent($content);
$chunk->setCacheable(false);
$output = $chunk->process();

switch ($type) {
    case 'css':
        $modx->regClientStartupHTMLBlock("<style type=\"text/css\">\n$output\n</style>");
        break;
    case 'js':
        if ($startup) {
          $modx->regClientStartupHTMLBlock("<script>\n$output\n</script>");
        } else {
          $modx->regClientHTMLBlock("<script>\n$output\n</script>");
        }
        break;
    case 'html':
        if ($startup) {
          $modx->regClientStartupHTMLBlock("\n$output\n");
        } else {
          $modx->regClientHTMLBlock("\n$output\n");
        }
        break;
}
return;
