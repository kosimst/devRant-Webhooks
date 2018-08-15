<?php

$key = '';

function init() {
	global $key;

	if(isset($_GET['key'])) {
		$key = $_GET['key'];
		return;
	}

	header('Location: /edit');
}

function GET() {
	global $key;

	$result = DB::query('webhook.delete', ['key' => $key]);
	$result2 = DB::query('webhook.deleteLog', ['key' => $key]);

	if($result === true && $result2 === true) {
		// Success
		header('Location: /');
		return;
	}

	View::console(DB::getError());
	View::error(500);
}