<?php

$key = '';
$form = [];
$errorLog = [];

function init() {
	global $key, $form, $errorLog;

	if(isset($_GET['key'])) {
		$key = $_GET['key'];

		$result = DB::query('webhook.get', ['key' => $key]);

		if($result->num_rows > 0) {
			$form = $result->fetch_assoc();

			$form = array_merge($form, json_decode($form['eventData'], true));

			$result = DB::query('log.get', ['key' => $key]);

			if($result->num_rows > 0) {
				$errorLog = DB::getRows($result);
			}

			return;
		}

		header('Location: /edit/key?notFound=' . $key);
		return;
	}

	header('Location: /edit/key');
}

function GET() {
	global $key, $form, $errorLog;

	View::setVar('success', (isset($_GET['success']) ? $_GET['success'] : false));
	View::setVar('key', $key);
	View::setVar('errorLog', $errorLog);
	View::setVar('errors', []);
	View::setVar('form', $form);
	View::setVar('cssFile', 'edit');
	View::simplates('edit');
}

function updateWebhook($data) {
	global $key;

	$data['key'] = $key;

	$eventData = [];
	if(isset($data['byUser'])) $eventData['byUser'] = $data['byUser'];
	if(isset($data['withTag'])) $eventData['withTag'] = $data['withTag'];
	if(isset($data['rantID'])) $eventData['rantID'] = intval($data['rantID']);
	$data['eventData'] = json_encode($eventData);

	$result = DB::query('webhook.update', $data);

	return ($result === true);
}

function POST() {
	global $key, $errorLog;

	$errors = [];

	$form = $_POST;

	if(isset($form['eventType']) && $form['eventType'] == 'none') {
		$form['eventType'] = '';
	}
	if(isset($form['method']) && $form['method'] == 'none') {
		$form['method'] = '';
	}
	if(isset($form['contentType']) && $form['contentType'] == 'none') {
		$form['contentType'] = '';
	}

	$eventTypes = ['newRant', 'newCommentOnRant',  'newWeeklyTopic'];
	if(!isset($form['eventType']) || empty($form['eventType']) || !in_array($form['eventType'], $eventTypes)) {
		$errors['eventType'] = 'Please select an event type!';
	}

	if(!isset($form['url']) || empty($form['url'])) {
		$errors['url'] = 'Please enter a URL!';
	}

	if(isset($form['url']) && !filter_var($form['url'], FILTER_VALIDATE_URL)) {
		$errors['url'] = 'Not a valid URL!';
	}

	$methods = ['GET', 'POST', 'DELETE', 'PUT', 'PATCH', 'OPTIONS', 'HEAD'];
	if(!isset($form['method']) || empty($form['method']) || !in_array($form['method'], $methods)) {
		$errors['method'] = 'Please select a method!';
	}

	$contentTypes = ['application/json', 'text/plain', 'application/x-www-form-urlencoded'];
	if(isset($form['contentType']) && !empty($form['contentType']) && !in_array($form['contentType'], $contentTypes)) {
		$errors['contentType'] = 'Content-Type must be one of the options!';
	}

	if(isset($form['body']) && isset($form['contentType']) && !empty($form['body']) && empty($form['contentType'])) {
		$errors['body'] = 'Body must be empty if no Content-Type is set!';
	}

	if(isset($form['eventType']) && $form['eventType'] == 'newRant') {

	}

	if(isset($form['eventType']) && $form['eventType'] == 'newCommentOnRant') {
		if(!isset($form['rantID']) || empty($form['rantID'])) {
			$errors['rantID'] = 'Please enter a rant ID!';
		}

		if(isset($form['rantID']) && !is_numeric($form['rantID'])) {
			$errors['rantID'] = 'Rant ID must be numeric!';
		}
	}

	if(empty($errors)) {
		// Valid
		$success = updateWebhook($form);

		if($success) {
			header('Location: /edit?success=true&key=' . $key);
			return;
		}

		View::console(DB::getError());
		View::error(500);
		return;
	}

	View::setVar('key', $key);
	View::setVar('errorLog', $errorLog);
	View::setVar('errors', $errors);
	View::setVar('form', $form);
	View::setVar('cssFile', 'edit');
	View::simplates('edit');
}