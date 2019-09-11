<?php
/**
 * redirectResource
 * A Snippet to redirect a resource to another
 */
 
$id = $modx->getOption('id',$scriptProperties,''); 
$url = $modx->makeUrl($id, "", "", "full");
$modx->sendRedirect($url);
