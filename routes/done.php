<?php

$key = '';

function init() {
	global $key;

	if(isset($_GET['key'])) {
		$key = $_GET['key'];
		return;
	}

	header('Location: /');
}

function GET() {
	global $key;
	View::setVar('key', $key);
	View::setVar('cssFile', 'done');
	View::simplates('done');
}

function POST() {
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
		$key = addWebhook($form);

		if($key) {
			header('Location: /done?key=' . $key);
			return;
		}

		View::error(500);
		return;
	}

	View::setVar('errors', $errors);
	View::setVar('form', $form);
	View::setVar('cssFile', 'create');
	View::simplates('create');
}