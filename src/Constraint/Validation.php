<?php

namespace App\Constraint;

use App\Constraint\PostValidation;

class Validation
{
    public function validate($data, $name)
    {
        $classValidation = "App\Constraint\\" . $name . "Validation";
        $classValidationInstance = new $classValidation();
        $errors = $classValidationInstance->check($data);
        return $errors;
        /* if ($name === 'Post') {
            $postValidation = new PostValidation();
            $errors = $postValidation->check($data);
            return $errors;
        } elseif ($name === 'Contact') {
            $contactValidation = new ContactValidation();
            $errors = $contactValidation->check($data);
            return $errors;
        } elseif ($name === 'Registration') {
            $registrationValidation = new RegistrationValidation();
            $errors = $registrationValidation->check($data);
            return $errors;
        } elseif ($name === 'Security') {
            $securityValidation = new SecurityValidation();
            $errors = $securityValidation->check($data);
            return $errors;
        } elseif ($name === 'Comment') {
            $commentValidation = new CommentValidation();
            $errors = $commentValidation->check($data);
            return $errors;
        } elseif ($name === 'UserUpdate') {
            $userUpdateValidation = new UserUpdateValidation();
            $errors = $userUpdateValidation->check($data);
            return $errors;
        } */
    }
}
