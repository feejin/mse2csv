<?php
/**
 * Convert Magic Set Editor HTML Spoiler into tab separated text
 * Classes schmasses
 *
 * @author     Colin Richardson <feejin@gmail.com>
 * @license    http://www.wtfpl.net  WTFPL
 * @version    1.0
 */

/* 1. PREPARE THE DATA
---------------------------------------------------------------------- */

$mse2csv = prepareData($_POST['spoiler-input']);

// load data
function prepareData($input = '') {
	if ( ! $_POST) return;

	if (! $input) {
		setMessage('Malfunction. Need input.', 'bad');
		return;
	}

	// check indices are valid - global is good yes?
	global $defaultIndices, $suppliedIndices;
	if ( ! checkIndices($defaultIndices, $suppliedIndices)) {
		setMessage('The supplied indices are invalid so your data is invalid and you are too.', 'bad');
		return;
	}

	// remove single quotes for ease of wrangling
	$input = str_replace("'", "", $input);


	// replace images with their alt text and deal with the bloody symbol span
	$input = preg_replace('/<span class="symbol">(.*?)<\/span>/', '$1', $input);
	$input = preg_replace('/<img.*?alt=([\w]+)[^\>]+>/', '$1', $input);

	// remove all tags we don't need for reference
	$input = strip_tags($input, '<span><li><br>');

	// remove any instances of multiple spaces, leading spaces,
	// tabs, newlines and carriage returns for easier regexing
	$input = preg_replace('/[ ]{2,}/', '', $input);
	$input = str_replace(["\t", "\n", "\r", ' >', '<br>'], ['', '', '', '>', ' / '], $input);

	// get an array of cards from the string
	preg_match_all('/<li class=card>(.*?)<\/li>/', $input, $matches);
	$cards = $matches[1];

	// continue to next step
	return extractData($cards);
}

/* 2. EXTRACT THE INFORMATION
---------------------------------------------------------------------- */

function extractData($cards) {
	global $suppliedIndices;
	$set = [];

	foreach ($cards as $card) {
		preg_match_all('/<span[^=]+=(.*?)>(.*?)<\/span>/', $card, $matches);
		foreach($suppliedIndices as $index) {
			$data[$index] = $matches[2][array_search($index, $matches[1])];
		}
		$set[] = $data;
	}

	return outputData($set);
}

/* 3. FORMAT THE INFORMATION
---------------------------------------------------------------------- */

function outputData($set) {
	global $suppliedIndices, $indexMap;

	$headers = [];
	foreach ($suppliedIndices as $index) {
		$headers[] = $suppliedIndices[$indexMap[$index]];
	}
	$output = implode("\t", $headers) . "\n";

	foreach($set as $card) {
		$output .= implode("\t", $card) . "\n";
	}

	setMessage('Success!', 'good');
	return $output;
}

