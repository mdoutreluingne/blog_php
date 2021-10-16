<?php

namespace App\Constraint;

use App\Constraint\Validation;

class CommentValidation extends Validation
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
        if ($name === 'content') {
            $error = $this->checkEntries($name, $value, 'Contenu', 2, null);
            $this->addError($name, $error);
        }
    }
}
