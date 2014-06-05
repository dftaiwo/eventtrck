<?php

class ValidationResult{

    private $valid,
        $cleanedData;

    private $errors = array();

    /**
     * @param mixed $cleanedData
     */
    public function setCleanedData($cleanedData)
    {
        $this->cleanedData = $cleanedData;
    }

    /**
     * @return mixed
     */
    public function getCleanedData()
    {
        return $this->cleanedData;
    }

    /**
     * @param mixed $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return mixed
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return ValidationErrors[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $field
     * @return ValidationErrors
     */
    public function getError($field){
        if(isset($this->errors[$field])){
            return $this->errors[$field];
        }
        return null;
    }

    public function addError($field, $error){
        if(!isset($this->errors[$field])){
            $this->errors[$field] = new ValidationErrors();
        }
        $this->getError($field)->addError($error);
    }
}

class ValidationErrors implements Iterator, Countable{
    private $errors = array();
    private $pointer = 0;

    function addError($error){
        $this->errors[] = $error;
    }

    function first(){
        if(!empty($this->errors)){
            return $this->errors[0];
        }
    }

    function last(){
        if(!empty($this->errors)){
            return $this->errors[count($this->errors) - 1];
        }
    }

    function next(){
        $row = $this->getError($this->pointer);
        if($row){
            ++$this->pointer;
        }
        return $row;
    }

    public function current()
    {
        return $this->getError($this->pointer);
    }

    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return ( ! is_null( $this->current() ) );
    }


    public function rewind()
    {
        $this->pointer = 0;
    }

    public function getError( $num ) {
        if ( $num >= count($this->errors) || $num < 0 ) {
            return null;
        }
        if ( isset( $this->errors[$num]) ) {
            return $this->errors[$num];
        }
    }

    public function count()
    {
        return count($this->errors);
    }


}