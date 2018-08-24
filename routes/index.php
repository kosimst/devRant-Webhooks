<?php

function GET() {
	View::setVar('errors', []);
	View::setVar('form', []);
	View::setVar('cssFile', 'create');
	View::simplates('create');
}

function addWebhook($data) {
	$key = substr(md5(uniqid(rand(), true)), 0, 16);
	$data['key'] = $key;

	$eventData = [];
	if(isset($data['byUser'])) $eventData['byUser'] = $data['byUser'];
	if(isset($data['withTag'])) $eventData['withTag'] = $data['withTag'];
	if(isset($data['rantID'])) $eventData['rantID'] = intval($data['rantID']);
	$data['eventData'] = json_encode($eventData);

	$result = DB::query('webhook.create', $data);

	if($result === true) {
		return $key;
	}
	
	return false;
}

function POST() {
	$errors = validateForm($_POST);

	if(empty($errors)) {
		// Valid
		$key = addWebhook($_POST);

		if($key) {
			header('Location: /done?key=' . $key);
			return;
		}

		View::error(500);
		return;
	}

	View::setVar('errors', $errors);
	View::setVar('form', $_POST);
	View::setVar('cssFile', 'create');
	View::simplates('create');
}