<?php
	require_once('include/config.php');
	require_once('include/EventModel.php');
	require_once('include/EventController.php');
	DatastoreService::setInstance(new DatastoreService($google_api_config));

	$eventController = new EventsController();
	$eventController->loadHeader();
	$eventController->handleRequest();
	$eventController->loadFooter();
//List Events
//Add Events
//View Events

	