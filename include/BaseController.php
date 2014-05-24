<?php

/**
 */
class BaseController {

	public $listLimit = 15;
	public $basePath = '';
	public $currentUrl = '';
	public $devLog = array();
	public $previousUrl = '/';

	function sRead($key, $defaultValue = NULL) {
		if (!isset($_SESSION) || !$_SESSION)
			return $defaultValue;
		if (!array_key_exists($key, $_SESSION)) {

			return $defaultValue;
		}
		return $_SESSION[$key];
	}

	function sWrite($key, $value) {
		$_SESSION[$key] = $value;
	}

	function setFlash($message, $messageType) {
		$this->sWrite('flash_message', array('message' => $message, 'messageType' => $messageType));
	}

	function readFlash() {

		$flashMessage = $this->sRead('flash_message');
		return $flashMessage;
	}

	function redirect($toUrl, $message = '', $messageType = 1) {
		$this->setFlash($message, $messageType);
		if (!$toUrl) {
			$toUrl = '/';
		}

		header("location: $toUrl");
		if (!$message)
			$message = 'Click here to continue';
		echo "<a href='$toUrl'>$message</a>";
		exit;
	}

	function loadTemplate($templateName, $viewVariables = array()) {
		foreach ($viewVariables as $field => $value) {
			$$field = $value;
		}

		$fullPath = "template/{$templateName}.php";

		if (!file_exists($fullPath)) {
			echo "<span class='appError'>Unable to locate requested template <u>{$templateName}</u></span>";
			return;
		}

		include($fullPath);
	}

	function url($relUrl) {
		if (stripos($relUrl, 'http') === 0)
			return $relUrl;
		return $this->getBasePath() . $relUrl;
	}

	function loadHeader() {
		
		$flashMessage = $this->readFlash();
		
		$this->loadTemplate('header', compact('flashMessage'));
	}

	function loadFooter() {
		$this->loadTemplate('footer');
	}

	function _now() {
		return date("Y-m-d H:i:s");
	}

	public function getBasePath() {
		return $this->basePath;
	}

	public function getCurrentUrl() {
		return $this->currentUrl;
	}

	function _url($url) {
		return $this->basePath . $url;
	}

}
