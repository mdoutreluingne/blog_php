<?php

namespace App\Constraint;

use App\Constraint\Validation;

class PostValidation extends Validation
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
        if ($name === 'title') {
            $error = $this->checkEntries($name, $value, 'titre', 2, 200);
            $this->addError($name, $error);
        } elseif ($name === 'chapo') {
            $error = $this->checkEntries($name, $value, 'chapo', 2, 255);
            $this->addError($name, $error);
        } elseif ($name === 'content') {
            $error = $this->checkEntries($name, $value, 'contenu', 2, null);
            $this->addError($name, $error);
        }
    }
}
