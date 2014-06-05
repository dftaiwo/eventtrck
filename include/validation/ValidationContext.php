<?php

class ValidationContext implements IValidationContext {
    /**
     * @var string
     */
    private $error_message;

    /**
     * @var array
     */
    private $error_message_arguments = array();

    /**
     * @var array
     */
    private $validation_data = array();

    private $preValidationCallback;

    function __construct($context_data=array(), $error_message=null, $error_message_args=array()){
        $this->setErrorMessage($error_message);
        $this->setValidationContextData($context_data);
        $this->setErrorMessageArguments($error_message_args);
    }

    function setErrorMessage($error_message){
        $this->error_message = $error_message;
        return $this;
    }

    function getErrorMessage(){
        return $this->error_message;
    }

    function addErrorMessageArgument($key, $val){
        $this->error_message_arguments[$key] = $val;
        return $this;
    }

    function getErrorMessageArguments(){
        return $this->error_message_arguments;
    }

    function setErrorMessageArguments($arguments=array()){
        foreach($arguments as $key=>$val){
            $this->addErrorMessageArgument($key, $val);
        }
        return $this;
    }

    function addValidationContextData($key, $val){
        $this->validation_data[$key] = $val;
        return $this;
    }

    function getValidationContextData($key){
        return $this->hasValidationContextData($key) ? $this->validation_data[$key] : null;
    }

    function hasValidationContextData($key){
        return isset($this->validation_data[$key]);
    }

    function getAllValidationContextData(){
        return $this->validation_data;
    }

    function setValidationContextData($contextData=array()){
        foreach($contextData as $key => $val){
            $this->addValidationContextData($key, $val);
        }
        return $this;
    }

    /**
     * @param $function callable
     */
    function setPreValidationCallback($function){
        $this->preValidationCallback = $function;
    }

    /**
     * @return mixed
     */
    function getPreValidationCallback(){
        return $this->preValidationCallback;
    }

} 