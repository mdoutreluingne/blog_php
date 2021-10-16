<?php

namespace App\Constraint;

use App\Constraint\Validation;

class ContactValidation extends Validation
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
        if ($name === 'lastname') {
            $error = $this->checkEntries($name, $value, 'Nom', 2, 50);
            $this->addError($name, $error);
        } elseif ($name === 'firstname') {
            $error = $this->checkEntries($name, $value, 'Prénom', 2, 50);
            $this->addError($name, $error);
        } elseif ($name === 'email') {
            $error = $this->checkEntries($name, $value, 'Email', 5, 255);
            $this->addError($name, $error);
        } elseif ($name === 'message') {
            $error = $this->checkEntries($name, $value, 'Message', 2, null);
            $this->addError($name, $error);
        }
    }
}
