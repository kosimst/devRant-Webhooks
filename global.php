<?php

function validateForm($form) {
	$errors = [];

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

	if(isset($form['body']) && isset($form['contentType'])) {
		if(!empty($form['body']) && empty($form['contentType'])) {
			$errors['body'] = 'Body must be empty if no Content-Type is set!';
		}

		if(!empty($form['body']) && !empty($form['contentType']) && $form['contentType'] === 'application/json') {
			$valid = json_decode($form['body']) === null ? false : true;

			if(!$valid) {
				$errors['body'] = 'Invalid JSON data!';
			}
		}
	}

	if(isset($form['eventType']) && ($form['eventType'] == 'newRant' || $form['eventType'] == 'newCommentOnRant')) {
		if(isset($form['byUser']) && !empty($form['byUser'])) {
			$users = explode(',', $form['byUser']);

			foreach ($users as $user) {
				$user = trim($user);

				$options = stream_context_create(['http' => ['ignore_errors' => true]]);
				$response = json_decode(file_get_contents('https://devrant.com/api/get-user-id?app=3&username=' . $user, false, $options));

				if(!$response->success) {
					$errors['byUser'] = 'User ' . $user . ' does not exist!';
					break;
				}
			}
		}
	}

	if(isset($form['eventType']) && $form['eventType'] == 'newCommentOnRant') {
		if(!isset($form['rantID']) || empty($form['rantID'])) {
			$errors['rantID'] = 'Please enter a rant ID!';
		}

		if(isset($form['rantID']) && !is_numeric($form['rantID'])) {
			$errors['rantID'] = 'Rant ID must be numeric!';
		}

		if(isset($form['rantID'])) {
			$options = stream_context_create(['http' => ['ignore_errors' => true]]);
			$response = json_decode(file_get_contents('https://devrant.com/api/devrant/rants/' . $form['rantID'] . '?app=3', false, $options));
			if($response->success === false) {
				$errors['rantID'] = 'Rant does not exist!';
			}
		}
	}

	return $errors;
}