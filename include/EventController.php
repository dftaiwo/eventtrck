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

	
	function listEvents(){
		
		$events = $this->Event->findEvents();
		
		$this->loadTemplate('events_list',compact('events'));
	}
	
	function viewEvent($eventId=0){
		
	}
	
	function createEvent(){
		$this->loadTemplate('create_event');
		
		if(!$_POST){
			return;
		}
		
		$this->Event->setEventId(uniqid('evt'));
		$this->Event->setName($_POST['event_name']);
		$this->Event->setDescription($_POST['description']);
		$this->Event->setEventDate($_POST['event_date']);
		$this->Event->setVenue($_POST['venue']);
		$this->Event->setCreated($this->_now());
		$this->Event->put();
		$this->redirect('listEvents','Event Saved');
		
	}
	
}