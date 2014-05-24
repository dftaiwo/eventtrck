<?php

/* 
 * Warning. This was purposefully written in 30 minutes.
 * I'm certain it will Need refactoring
 */

require_once('BaseController.php');
class EventsController extends BaseController{
	
	public $currentAction;
	public $Event;
	function __construct(){
		require_once('include/EventModel.php');
		$this->Event = new EventModel();
	}
	
	function handleRequest(){
		
		if (!isset($_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = '/';
		}
		
		$args = substr($_SERVER['REQUEST_URI'], 1);
		
		$passedArgs = explode('/', $args);
		
		$requestedAction = array_shift($passedArgs);
		
		if(!$requestedAction) $requestedAction = 'listEvents';
		if (substr($requestedAction, 0, 1) == '_') {
			//Don't even dignify this with a response becuase this is an internal function
			exit;
		}
		 
		call_user_func_array(array($this, $requestedAction), $passedArgs);
		
	}
	
	function loadHeader() {
		
		$this->loadTemplate('header');
	}

	function loadFooter() {
		$this->loadTemplate('footer');
	}

	
	function listEvents(){
		
		
		pr($this->Event->findEvents());
		
		$this->loadTemplate('events_list');
	}
	
	function createEvent(){
		
		$this->Event->setName('Sample Event');
		$this->Event->setDescription('Sample Description');
		$this->Event->setEventDate('2014-05-24 12:00:00');
		$this->Event->setVenue("Co-Creation Hub, Sabo Yaba");
		$this->Event->put();
		
	}
	
}