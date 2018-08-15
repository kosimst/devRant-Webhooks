<?php

function GET() {
	if(isset($_GET['notFound'])) {
		View::setVar('notFound', true);
		View::setVar('key', $_GET['notFound']);
	}

	View::setVar('cssFile', 'key');
	View::simplates('edit/key');
}

function POST() {
	$error = false;

	if(!isset($_POST['key']) || empty($_POST['key'])) {
		$error = 'Please enter a key!';
	}

	if(!$error) {
		$key = $_POST['key'];

		$result = DB::query('webhook.get', ['key' => $key]);

		if ($result->num_rows > 0) {
			header('Location: /edit?key=' . $key);
			return;
		}

		$error = 'Key not found. Please check!';
		View::setVar('key', $key);
	}

	View::setVar('error', $error);
	View::setVar('cssFile', 'key');
	View::simplates('edit/key');
}