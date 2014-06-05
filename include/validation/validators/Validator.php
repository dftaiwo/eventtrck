<?php

class Validator {

    private $name;

    function __construct($name){
        $this->name = $name;
    }

    /**
     * returns the name this validator was registered with
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function clean($value){
        return $value;
    }

    /**
     * @param $value
     * @param $context ValidationContext
     * @return mixed
     */
    protected function doValidate($value, $context=null){
        return true;
    }

    /**
     * @param $value
     * @param $context ValidationContext
     */
    protected function preValidate($value, $context=null){

    }

    /**
     * @param $value
     * @param $context ValidationContext
     */
    protected function postValidate($value, $context=null){

    }

    /**
     * @param $value
     * @param $field
     * @param $context ValidationContext
     * @return mixed
     */
    public final function performValidation($value, $field, $context=null){
        $this->preValidate($value, $context);
        $callback = $context->getPreValidationCallback();
        if($callback){
            $temp = call_user_func($callback, array($field, $value, $context));
            if($temp){
                $context = $temp;
            }
        }

        $result = $this->doValidate($value, $context);
        $this->postValidate($value, $context);
        return $result;
    }

    /**
     * returns the default error message format that will be used to generate the error message that is displayed to the
     *  user. An error message format can contain numeric placeholders wrapped in curly braces. This allows arguments
     * @param $context ValidationContext
     * @return string
     */
    public function getDefaultErrorMessage($context){
        return '';
    }
}