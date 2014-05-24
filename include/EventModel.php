<?php

require_once 'Model.php';

//@TODO  Error trapping for incomplete objects e.g empty avatar field
/**
 * Model class for feed objects
 */
class EventModel extends Model {

	const EVENT_MODEL_KIND = 'Event';
	const EVENT_ID = 'event_id';
	const EVENT_NAME = 'name';
	const EVENT_DESCRIPTION = 'description';
	const EVENT_DATE = 'event_date';
	const EVENT_VENUE = 'venue';

	private
			  $eventId,
			  $name,
			  $description,
			  $eventDate,
			  $venue;

	public function __construct() {
		parent::__construct();
	}

	protected static function getKindName() {
		return self::EVENT_MODEL_KIND;
	}

	protected function getKindProperties() {
		$property_map = array(
				  self::EVENT_NAME => parent::createStringProperty($this->getName(), true),
				  self::EVENT_DESCRIPTION => parent::createStringProperty($this->getDescription(), true),
				  self::EVENT_DATE => parent::createStringProperty($this->getEventDate(), false),
				  self::EVENT_VENUE => parent::createStringProperty($this->getVenue(), false),
		);
		return $property_map;
	}

	public function getEventId() {
		return $this->eventId;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getEventDate() {
		return $this->eventDate;
	}

	public function getVenue() {
		return $this->venue;
	}

	public function setEventId($eventId) {
		$this->eventId = $eventId;
		return $this;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	public function setEventDate($eventDate) {
		$this->eventDate = $eventDate;
		return $this;
	}

	public function setVenue($venue) {
		$this->venue = $venue;
		return $this;
	}

	public function getEvent() {
		
	}

	public function listEvents() {
		
	}

	public function updateEvent() {
		
	}

	public function deleteEvent() {
		
	}

	protected static function extractQueryResults($results) {
		$query_results = [];
		foreach ($results as $result) {
			$id = @$result['entity']['key']['path'][0]['id'];
			$key_name = @$result['entity']['key']['path'][0]['name'];
			$props = $result['entity']['properties'];
			foreach($props as $propKey=>$propValue){
				$row[$propKey] = $propValue->getStringValue();
			}
			$query_results[] = $row;
		}
		
		return $query_results;
	}

	public function findEvents() {
		return $this->all();
	}

}
