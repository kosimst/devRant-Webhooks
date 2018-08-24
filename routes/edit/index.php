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

	$errors = validateForm($_POST);

	if(empty($errors)) {
		// Valid
		$success = updateWebhook($_POST);

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
	View::setVar('form', $_POST);
	View::setVar('cssFile', 'edit');
	View::simplates('edit');
}