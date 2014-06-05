<?php
define('BASE_DIRECTORY', '../../../');
require_once('../ValidationUtility.php');

class ValidationTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function baseTest()
    {

        $data_to_validate = array(
            'firstname' => 'Kembene',
            'lastname' => ''
        );

        $query = ValidationUtility::createValidationQuery();
        $validation_result = $query
            ->withField('firstname')
                //this validation should pass
                ->validateUsing('required')
                    ->addErrorMessageArgument(0, 'firstname')

                //this validation should fail because firstname requires a minimum of 10 characters and Kembene is 7 chars
                ->validateUsing('length')
                    ->addValidationContextData('min', 10)
                    ->addErrorMessageArgument(0, 'firstname')
            ->withValidator('required')
                //this validation should fail because there is no value in lastname and it is required
                ->validateAgainst('lastname')
                    ->addErrorMessageArgument(0, 'lastname')

            ->validate($data_to_validate);


        //the two fields (firstname and lastname) must have errors
        $this->assertCount(2, $validation_result->getErrors());

        $firstname_errors = $validation_result->getError('firstname');
        $lastname_errors = $validation_result->getError('lastname');

        $this->assertFalse($validation_result->isValid());


        //firstname should have only one error
        $this->assertCount(1, $firstname_errors);

        // the error message, according to the defaultErrorMessage of the Length validator should read
        // firstname should be at least 10 characters
        $this->assertEquals('firstname should be at least 10 characters', strtolower($firstname_errors->first()));



        //lastname should have only one error because of the required flag
        $this->assertCount(1, $lastname_errors);

        // the error message, according to the defaultErrorMessage of the Required validator should read
        // lastname is required
        $this->assertEquals('lastname is required', strtolower($lastname_errors->first()));
    }

    // ...
}