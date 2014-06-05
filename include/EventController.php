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
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
            /*$validatorService = ValidationServiceProvider::getValidationService();

            $validator = $validatorService->getValidator('required')
                //->validateAgainst('event_name')
                //->addErrorMessageArgument(0, 'Event Name')

                ->validateAgainst('description')
                ->addErrorMessageArgument(0, 'Description')

                //->getValidator('length')
                //->validateAgainst('event_name')
                ->withField('event_name')
                ->validateUsing('required')
                ->addErrorMessageArgument(0, 'Event Name')

                ->validateUsing('length')
                ->addErrorMessageArgument(0, 'Event Name')
                //->addValidationContextData('min', 5)
                ->addValidationContextData('max', 7)

                ->getValidator('required')
                ->validateAgainst('event_date')
                ->addErrorMessageArgument(0, 'Event date')

                ->validateAgainst('venue')
                ->addErrorMessageArgument(0, 'Venue');

            //pr(ValidationServiceProvider::getValidationService());*/

            $validationQuery = ValidationUtility::createValidationQuery();

            $validationQuery
                ->withField('event_name')
                    ->validateUsing('required')
                        ->addErrorMessageArgument(0, 'Event Name')
                    ->validateUsing('length')
                        ->addValidationContextData('min', 5)
                        ->addErrorMessageArgument(0, 'Event Name')

                ->withValidator('required')
                    ->validateAgainst('event_date')
                        ->addErrorMessageArgument(0, 'Event Date')
                    ->validateAgainst('venue')
                        ->addErrorMessageArgument(0, 'Venue')
                    ->validateAgainst('description')
                        ->addErrorMessageArgument(0, 'Description');

            $validation_result = $validationQuery->validate($_POST);

            if($validation_result->isValid()){
                $cleaned = $validation_result->getCleanedData();
                $this->Event->setEventId(uniqid('evt'));
                $this->Event->setName($cleaned['event_name']);
                $this->Event->setDescription($cleaned['description']);
                $this->Event->setEventDate($cleaned['event_date']);
                $this->Event->setVenue($cleaned['venue']);
                $this->Event->setCreated($this->_now());
                $this->Event->put();
                $this->redirect('listEvents','Event Saved');
                return;
            }
            else{
                $error_list = $validation_result->getErrors();
                foreach($error_list as $errors){
                    foreach($errors as $error){
                        pr($error);
                    }
                }
            }
		}
        /*$context = new ValidationContext(array(), '{0} is required', array('0'=>'Username'));
        var_dump(ValidationErrorMessageTranslator::translateErrorMessage(ValidationServiceProvider::
            getValidationService()->getValidator('required'), $context, '23'));*/

        $this->loadTemplate('create_event.php', array(), false);
	}
	
}