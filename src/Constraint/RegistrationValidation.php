<?php

namespace App\Constraint;

use App\Constraint\Validation;

class RegistrationValidation extends Validation
{
    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

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
            $error = $this->checkLastname($name, $value);
            $this->addError($name, $error);
        } elseif ($name === 'firstname') {
            $error = $this->checkFirstname($name, $value);
            $this->addError($name, $error);
        } elseif ($name === 'email') {
            $error = $this->checkEmail($name, $value);
            $this->addError($name, $error);
        } elseif ($name === 'password') {
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error)
    {
        if ($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkLastname($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Nom', $value);
        }
        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('Nom', $value, 2);
        }
        if ($this->constraint->maxLength($name, $value, 50)) {
            return $this->constraint->maxLength('Nom', $value, 50);
        }
    }

    private function checkFirstname($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Prénom', $value);
        }
        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('Prénom', $value, 2);
        }
        if ($this->constraint->maxLength($name, $value, 50)) {
            return $this->constraint->maxLength('Prénom', $value, 50);
        }
    }

    private function checkEmail($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Email', $value);
        }
        if ($this->constraint->minLength($name, $value, 5)) {
            return $this->constraint->minLength('Email', $value, 5);
        }
        if ($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('Email', $value, 255);
        }
        if ($this->constraint->email($value)) {
            return $this->constraint->email($value);
        }
    }

    private function checkPassword($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Mot de passe', $value);
        }
        if ($this->constraint->minLength($name, $value, 6)) {
            return $this->constraint->minLength('Mot de passe', $value, 6);
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
        if ($this->constraint->repeatPassword($name, $password, $repeatpassword)) {
            return $this->constraint->repeatPassword('Mot de passe', $password, $repeatpassword);
        }
    }
}
