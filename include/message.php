<?php
/**
 * Convert Magic Set Editor HTML Spoiler into tab separated text
 * Output messages
 *
 * @author     Colin Richardson <feejin@gmail.com>
 * @license    http://www.wtfpl.net  WTFPL
 * @version    1.0
 */

function setMessage($message, $status) {
	$_SESSION['message']['content'] = $message;
	$_SESSION['message']['status'] = $status;
}

function getMessage() {
	if ($_SESSION['message']) {
		return '<div class="message ' . $_SESSION['message']['status'] . '">' . $_SESSION['message']['content'] . '</div>';
		unset($_SESSION['message']);
	}
}
