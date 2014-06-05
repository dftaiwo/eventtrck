<?php

session_start();
ob_start(); //Still looking for a better yet simpler way to do redirects after outputs adn update meta tags, so I'm using ob_ things


	require_once('include/config.php');
	require_once('include/EventModel.php');
	require_once('include/EventController.php');
	DatastoreService::setInstance(new DatastoreService($google_api_config));

    /**
     * Just a thought. I believe we are going to have more than one controllers at the end of the day, I thus suggest another
     * layer here that will dynamically resolve controllers based on urls, more or less like a URLResolver that will resolve
     * URL's to controllers
     */
    $eventController = new EventsController();
	$eventController->loadHeader();
	$eventController->handleRequest();
	$eventController->loadFooter();
//List Events
//Add Events
//View Events

	$pageContents = ob_get_contents();
	ob_end_clean();
	echo $pageContents;
