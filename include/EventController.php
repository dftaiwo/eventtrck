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
        parent::__contruct();
		require_once('include/EventModel.php');
		$this->Event = new EventModel();
	}

    /**
     * comment by kembene
     *
     *  I feel its better to move handleRequest method (which was formally here) to the base controller class so as to
     *  lessen the burden on sub-controllers in terms of routing. Let sub controllers focus on their business logic
     */

	
	function listEvents(){
		
		$events = $this->Event->findEvents();
		return $this->loadTemplate('events_list.php',compact('events'), true);
	}
	
	function viewEvent($eventId=0){
		
	}
	
	function createEvent(){
		$this->loadTemplate('create_event.php', array(), false);

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