<?php

/**
 * Convert Magic Set Editor HTML Spoiler into tab separated text
 * Indices used for output
 *
 * @author     Colin Richardson <feejin@gmail.com>
 * @license    http://www.wtfpl.net  WTFPL
 * @version    1.0
 */

$defaultIndices = [
	'name',
	'casting-cost',
	'rarity',
	'type',
	'pt',
	'rule-text',
	'flavor-text',
	'card-number'
];

$indexMap= [
	'name' => 'Name',
	'casting-cost' => 'Casting Cost',
	'rarity' => 'Rarity',
	'type' => 'Type',
	'pt' => 'P/T',
	'rule-text' => 'Rules',
	'flavor-text' => 'Flavour',
	'card-number' => 'Card No'
];

$suppliedIndices = $_POST['indices'] ?: false;

// deal with both newlines and carriage returns, convert to array
$suppliedIndices = explode(',', str_replace(["\r", "\n", ",,"], ',', $suppliedIndices));

function checkIndices($defaults, $supplied) {
	$d = $defaults; sort($d);
	$s = $supplied; sort($s);
	if ($d == $s) {
		return $supplied;
	}
	return false;
}

function getIndices() {
	global $defaultIndices, $suppliedIndices;
	if ($indices = checkIndices($defaultIndices, $suppliedIndices)) {
		$val = $suppliedIndices;
	} else {
		$val = $defaultIndices;
	}
	return implode("\n" , $val);
}
