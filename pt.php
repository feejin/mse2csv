<?php
/**
 * Convert Magic Set Editor HTML Spoiler into tab separated text
 * Front end
 *
 * @author     Colin Richardson <feejin@gmail.com>
 * @license    http://www.wtfpl.net  WTFPL
 * @version    1.0
 */

// function to count number of times a value appears in array
function insts($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}

$spoiler = file_get_contents('spoiler/index.html');

// grab powers and toughnesses
preg_match_all('/<span class=\'pt\'[^>]+>(.*?)<\/span>/', $spoiler, $matches);

// get list of all pts and unique ones
$all_pts = $matches[1];
sort($all_pts);

$unq_pts = array_unique($all_pts);
array_unique($unq_pts);

$output = [];

// get counts
foreach($unq_pts as $val) {
	if ($val) {
		$output[$val] = insts($val, $all_pts);
	}
}

include('template/pt.html');
