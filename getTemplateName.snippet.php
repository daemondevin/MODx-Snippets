<?php
/**
 * getTemplateName
 *
 * With this snippet you can retrieve a templates name instead of 
 * its ID number.
 *
 * PROPERTIES
 * &id   integer   The ID of the template resource to use.
 *                 Defaults to the currently used template.
 *
 * EXAMPLE
 * Use it to pass the templates name in a property value:
 * [[$HeadMarkup? &template=`[[getTemplateName]]`]]
 * 
 * The above will allow you to retrieve the property like:
 * [[+template
 *   :is=`blog`
 *   :then=`[[*publishedon:strtotime:date=`%e %B %Y`]]`
 *   :else=`[[*createdon:strtotime:date=`%e %B %Y`]]`
 * ]]
 * 
 * Use it to define which stylesheet to use like:
 * [[+template
 *   :notempty=`<link href="[[getTemplateName]].css">`
 * ]]
 * 
 * The above will then enable you to use only template 
 * specific stylesheets while allowing you to reuse the
 * same markup between the HEAD tags.
 * 
 * @author  daemon.devin <daemon.devin@gmail.com>
 * @link    https://github.com/daemondevin/MODx-Snippets
 * @version 1.0
 */
$id = $modx->getOption('id',$scriptProperties,$modx->resource->get('id'));

$templateObj = $modx->resource->getOne('Template');

return strtolower($templateObj->get('templatename'));
