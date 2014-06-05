<?php


class ValidationRule {

    private $validator_name,
            $validator_context;

    /**
     * @param $validator_name string
     * @param $validator_context ValidationContext
     */
    function __construct($validator_name, $validator_context)
    {
        $this->validator_context = $validator_context;
        $this->validator_name = $validator_name;
    }

    /**
     * @return mixed
     */
    public function getValidatorContext()
    {
        return $this->validator_context;
    }

    /**
     * @return mixed
     */
    public function getValidatorName()
    {
        return $this->validator_name;
    }



} 