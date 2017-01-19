<?php
/**
 * Convert Magic Set Editor HTML Spoiler into tab separated text
 * Front end
 *
 * @author     Colin Richardson <feejin@gmail.com>
 * @license    http://www.wtfpl.net  WTFPL
 * @version    1.0
 */

$spoiler = file_get_contents('spoiler/index.html');

// replace image tags with alt attributes and remove other tags we don't need
$spoiler = preg_replace('/<img.*?alt=\'(.*?)\'[^\>]+>/', '$1', $spoiler);
$spoiler = strip_tags($spoiler, '<span><h2><ul><li><br>');

include('template/clean.html');
