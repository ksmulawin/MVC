<?php
	// include your composer dependencies
	require_once 'vendor/autoload.php';

	$client = new Google_Client();
	$client->setAuthConfig('KSM_Projects-643498408283.json');
	$client->addScope(Google_Service_Drive::DRIVE);
	$client->useApplicationDefaultCredentials();
	
	$service = new Google_Service_Drive($client);
	$content = retrieveAllFiles();
	
	function retrieveAllFiles($service) {
	  $result = array();
	  $pageToken = NULL;

	  do {
		try {
		  $parameters = array();
		  if ($pageToken) {
			$parameters['pageToken'] = $pageToken;
		  }
		  $files = $service->files->listFiles($parameters);

		  $result = array_merge($result, $files->getFiles());
		  $pageToken = $files->getNextPageToken();
		} catch (Exception $e) {
		  print "An error occurred: " . $e->getMessage();
		  $pageToken = NULL;
		}
	  } while ($pageToken);
	  return $result;
	}