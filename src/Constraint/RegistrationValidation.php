<?php

namespace App\Constraint;

use App\Constraint\Validation;

class RegistrationValidation extends Validation
{
    public function check(array $post)
    {
        $password ="";
        foreach ($post as $key => $value) {
            //Save password
            if ($key === 'password') {
                $password = $value;
            }
            //Call constraint for repeatpassword
            if ($key === 'repeatpassword') {
               /*  var_dump($password, $value);
                die; */
                $error = $this->checkRepeatPassword($key, $password, $value);
                $this->addError($key, $error);
            }

            //Check another field
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if ($name === 'lastname') {
            $error = $this->checkEntries($name, $value, 'Nom', 3, 50);
            $this->addError($name, $error);
        } elseif ($name === 'firstname') {
            $error = $this->checkEntries($name, $value, 'Prénom', 3, 50);
            $this->addError($name, $error);
        } elseif ($name === 'email') {
            $error = $this->checkEntries($name, $value, 'Email', 6, 255);
            $this->addError($name, $error);
        } elseif ($name === 'password') {
            $error = $this->checkEntries($name, $value, 'Mot de passe', 2, null);
            $this->addError($name, $error);
        }
    }

    private function checkRepeatPassword($name, $password, $repeatpassword)
    {
        if ($this->constraint->notBlank($name, $repeatpassword)) {
            return $this->constraint->notBlank('Mot de passe', $repeatpassword);
        }
        if ($this->constraint->minLength($name, $repeatpassword, 6)) {
            return $this->constraint->minLength('Mot de passe', $repeatpassword, 6);
        }
        if ($this->constraint->repeatPassword($password, $repeatpassword)) {
            return $this->constraint->repeatPassword($password, $repeatpassword);
        }
    }
}
