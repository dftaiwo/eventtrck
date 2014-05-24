<?php

	require_once('include/config.php');

	require_once('include/EventModel.php');

	DatastoreService::setInstance(new DatastoreService($google_api_config));

	$ev = new EventModel();
	$ev->setName('Sample Event')->setDescription('Sample Description');
	$ev->setEventDate('2014-05-24 12:00:00');
	$ev->setVenue("Co-Creation Hub, Sabo Yaba");
	$ev->put();
	
	

//List Events
//Add Events
//View Events
