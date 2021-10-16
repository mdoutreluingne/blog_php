<?php

namespace App\Constraint;

use App\Constraint\Validation;

class SecurityValidation extends Validation
{
    public function check(array $post)
    {
        foreach ($post as $key => $value) {
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if ($name === 'email') {
            $error = $this->checkEntries($name, $value, 'Email', 5, 255);
            $this->addError($name, $error);
        } elseif ($name === 'password') {
            $error = $this->checkEntries($name, $value, 'Mot de passe', 6, null);
            $this->addError($name, $error);
        }
    }
}
