<?php

namespace App\Constraint;

use App\Constraint\Constraint;

class Validation
{
    protected $errors = [];
    protected $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function validate($data, $name)
    {
        $classValidation = "App\Constraint\\" . $name . "Validation";
        $classValidationInit = new $classValidation();
        $errors = $classValidationInit->check($data);

        return $errors;
    }

    protected function addError($name, $error)
    {
        if ($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    /**
     * checkEntries
     *
     * @param string $name
     * @param mixed $value
     * @param string $field
     * @param integer $minLimit
     * @param integer $maxLimit
     * @return void
     */
    protected function checkEntries(string $name, $value, string $field, int $minLimit, ?int $maxLimit)
    {
        if ($this->constraint->notBlank($name, $value)) {

            return $this->constraint->notBlank($field, $value);
        }

        if ($this->constraint->minLength($name, $value, $minLimit)) {

            return $this->constraint->minLength($field, $value, $minLimit);
        }

        if ($this->constraint->maxLength($name, $value, $maxLimit) && !empty($maxLimit)) {

            return $this->constraint->maxLength($field, $value, $maxLimit);
        }

        if ($this->constraint->email($value) && $name === 'email') {

            return $this->constraint->email($value);
        }
    }
}
