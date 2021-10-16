<?php

namespace App\Constraint;

use App\Constraint\Validation;

class UserUpdateValidation extends Validation
{
    public function check(array $post)
    {
        foreach ($post as $key => $value) {
            //Check another field
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if ($name === 'last_name') {
            $error = $this->checkEntries($name, $value, 'Nom', 2, 50);
            $this->addError($name, $error);
        } elseif ($name === 'first_name') {
            $error = $this->checkEntries($name, $value, 'Prénom', 2, 50);
            $this->addError($name, $error);
        } elseif ($name === 'email') {
            $error = $this->checkEntries($name, $value, 'Email', 5, 255);
            $this->addError($name, $error);
        }
    }
}
