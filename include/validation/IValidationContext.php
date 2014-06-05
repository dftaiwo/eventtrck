<?php


interface IValidationContext {

    /**
     * sets the error message template that will be used to generate the error message for a failed validation
     * @param $error_message string
     * @return mixed
     */
    function setErrorMessage($error_message);

    /**
     * Registers an error message argument that will be applied on the error message template when generating error
     * messages for a failed validation
     * @param $key
     * @param $value
     * @return mixed
     */
    function addErrorMessageArgument($key, $value);

    /**
     * Validation context data are extra data that is used by a validator when validating a value. Validators are by
     * default singletons which are reused, thus validation context data provides variables that a validator requires to
     * work with when performing a specific validation
     * @param $key
     * @param $val
     * @return mixed
     */
    function addValidationContextData($key, $val);

    /**
     * @param $function
     * @return mixed
     */
    function setPreValidationCallback($function);

} 