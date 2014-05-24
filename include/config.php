<?php

$google_api_config = [
		  'application-id' => 'eventtrck',
		  'service-account-name' => '85269332869-vuoo2651dkhqndclvc28h96drmqjt8vn@developer.gserviceaccount.com',
		  'private-key' => file_get_contents('./include/keys/c19c9bba95ab58594f502779f478568264b549b7-privatekey.p12'),
		  'dataset-id' => 'eventtrck'
];

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . './lib' . PATH_SEPARATOR.'./lib/google-api-php-client/src' . PATH_SEPARATOR.'./include' . PATH_SEPARATOR);
	