<?php

/**
 */

require_once("views/RendererEngineFactory.php");
require_once("validation/ValidationServiceProvider.php");
class BaseController {

	public $listLimit = 15;
	public $basePath = '';
	public $currentUrl = '';
	public $devLog = array();
	public $previousUrl = '/';

    /**
     * @var BaseRenderingEngine null
     */
    public $rendererEngine = null;

    public function __contruct(){
        $this->rendererEngine = RendererEngineFactory::getRenderingEngine();
    }

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

	function loadTemplate($templateName, $viewVariables = array(), $buffer=false) {
        //its better if we delegate this task of rendering to another service
        return $this->rendererEngine->render($templateName, $viewVariables, $buffer);

		/*foreach ($viewVariables as $field => $value) {
			$$field = $value;
		}

		$fullPath = "template/{$templateName}.php";

		if (!file_exists($fullPath)) {
			echo "<span class='appError'>Unable to locate requested template <u>{$templateName}</u></span>";
			return;
		}

		include($fullPath);*/
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

        $result = call_user_func_array(array($this, $requestedAction), $passedArgs);

        if(is_array($result)){
            $template = array_shift($result);
            $variables = count($result) > 0 ? array_shift($result) : array();
            $result = $this->loadTemplate($template, $variables);
            if($result){
                echo $result;
            }
        }
        if(is_string($result)){
            echo $result;
        }

    }

	function url($relUrl) {
		if (stripos($relUrl, 'http') === 0)
			return $relUrl;
		return $this->getBasePath() . $relUrl;
	}

	function loadHeader() {
		
		$flashMessage = $this->readFlash();
		
		$this->loadTemplate('header.php', compact('flashMessage'));
	}

	function loadFooter() {
		$this->loadTemplate('footer.php');
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
