<?php
/**
 * image64 Snippet
 *
 * Copyright 2019 by daemon.devin <daemon.devin@gmail.com>
 * Created on 01-17-2017
 *
 * image64 is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * image64 is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * image64; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package image64
 * @version 2.0
 */

/**
 * Description
 * -----------
 * Converts a specified image to a base64 encoding.
 *
 * PROPERTIES
 * ----------
 * &id        string   optional    The css id selector attribute
 * &alt       string   optional    What to display in the alt attribute
 * &img       string   required    path to desired image file from webroot
 * &css       boolean  required    If true will return just the data encoding. if false will return an img tag.
 * &class     string   optional    The css class attribute
 * &extra     string   optional    Specify any other attributes you'd like here. Example: data-user-attribute="something"
 * &title     string   optional    The title attribute
 * &imgtype   string   optional    The mimetype of the image. If left blank, the snippet will try and find it for you.
 *
 * EXAMPLE
 * For use within a css file or within <style></style> tags
 *
 * background: url("[[!image64? &img=`img/php.png` &css=`true`]]") no-repeat left 2px;
 *
 * Output:
 * background: url("data:image/png;base64,<!--BASE64 ENCODING HERE-->") no-repeat left 2px;
 *
 * For use within an img tag
 *
 * [[!image64? &img=`img/avatar.png` &alt=`demon.devin's Avatar`]]
 *
 * Output:
 * <img src="data:image/png;base64,<!--BASE64 ENCODING HERE-->" alt="demon.devin's Avatar" />
 *
 * With &extra=``
 *
 * [[!image64? &img=`img/avatar.png` &extra=`title="demon.devin's Avatar" data-attr="user-image"`]]
 *
 * Output:
 * <img src="data:image/png;base64,<!--BASE64 ENCODING HERE-->"" title="demon.devin's Avatar" data-attr="user-image" />
 *
 * Output: #
 * Output pagesource: #
 **/

$id       = $modx->getOption('id',$scriptProperties,'');
$alt      = $modx->getOption('alt',$scriptProperties,'');
$img      = $modx->getOption('img',$scriptProperties,null);
$css      = $modx->getOption('css',$scriptProperties,false);
$extra    = $modx->getOption('extra',$scriptProperties,'');
$title    = $modx->getOption('title',$scriptProperties,'');
$class    = $modx->getOption('class',$scriptProperties,'');
$imgtype  = $modx->getOption('extra',$scriptProperties,'');

$types = [
    "bmp"  => "image/bmp",
    "cgm"  => "image/cgm",
    "g3"   => "image/g3fax",
    "gif"  => "image/gif",
    "ief"  => "image/ief",
    "jpeg" => "image/jpeg",
    "jpg"  => "image/jpeg",
    "jpe"  => "image/jpeg",
    "png"  => "image/png",
    "btif" => "image/prs.btif",
    "svg"  => "image/svg+xml",
    "svgz" => "image/svg+xml",
    "tiff" => "image/tiff",
    "tif"  => "image/tiff",
    "psd"  => "image/vnd.adobe.photoshop",
    "djvu" => "image/vnd.djvu",
    "djv"  => "image/vnd.djvu",
    "dwg"  => "image/vnd.dwg",
    "dxf"  => "image/vnd.dxf",
    "fbs"  => "image/vnd.fastbidsheet",
    "fpx"  => "image/vnd.fpx",
    "fst"  => "image/vnd.fst",
    "mmr"  => "image/vnd.fujixerox.edmics-mmr",
    "rlc"  => "image/vnd.fujixerox.edmics-rlc",
    "mdi"  => "image/vnd.ms-modi",
    "npx"  => "image/vnd.net-fpx",
    "wbmp" => "image/vnd.wap.wbmp",
    "xif"  => "image/vnd.xiff",
    "ras"  => "image/x-cmu-raster",
    "cmx"  => "image/x-cmx",
    "fh"   => "image/x-freehand",
    "fhc"  => "image/x-freehand",
    "fh4"  => "image/x-freehand",
    "fh5"  => "image/x-freehand",
    "fh7"  => "image/x-freehand",
    "ico"  => "image/x-icon",
    "pcx"  => "image/x-pcx",
    "pic"  => "image/x-pict",
    "pct"  => "image/x-pict",
    "pnm"  => "image/x-portable-anymap",
    "pbm"  => "image/x-portable-bitmap",
    "pgm"  => "image/x-portable-graymap",
    "ppm"  => "image/x-portable-pixmap",
    "rgb"  => "image/x-rgb",
    "xbm"  => "image/x-xbitmap",
    "xpm"  => "image/x-xpixmap",
    "xwd"  => "image/x-xwindowdump",
];

$output = '';

$img = MODX_BASE_PATH . $img;

if ($img) {
  if (!$imgtype && function_exists("finfo_open")) {
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $imgtype = $finfo->file($img);
    if ($imgtype == "application/octet-stream") {
      $imgtype = null;
    }
  }
  if (!$imgtype && function_exists("mime_content_type")) {
    $imgtype = mime_content_type($img);
    if ($imgtype == "application/octet-stream") {
      $imgtype = null;
    }
  }
  if ($pos = strrpos($img, '.')) {
    $extension = strtolower(substr($img, $pos + 1));
    if (!in_array($types[$extension])) {
      $imgtype = $types[$extension];
    }
  }
  $imgbinary = fread(fopen($img, "r"), filesize($img));
  $img64 = 'data:' . $imgtype . ';base64,' . base64_encode($imgbinary);
  if ($css) {
    $output = $img64;
  } else {
    $output  = "<img src=\"$img64\"";
    if(!empty($alt)){$output    .= " alt=\"$alt\" ";}
    if(!empty($id)){$output     .= " id=\"$id\" ";}
    if(!empty($class)){$output  .= " class=\"$class\" ";}
    if(!empty($title)){$output  .= " title=\"$title\" ";}
    if(!empty($extra)){$output  .= " $extra";}
    $output .= " />";
  }
} else {
  $modx->log(modX::LOG_LEVEL_ERROR, '[image64] Specified image ('.$img.') is null or doesn\'t exist!');
  $output = "[image64] File not found!";
}
return $output;
