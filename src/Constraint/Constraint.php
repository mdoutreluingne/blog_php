<?php

namespace App\Constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if (empty($value)) {
            return 'Le champ ' . $name . ' saisi est vide';
        }
    }
    public function minLength($name, $value, $minSize)
    {
        if (strlen($value) < $minSize) {
            return 'Le champ ' . $name . ' doit contenir au moins ' . $minSize . ' caractères';
        }
    }
    public function maxLength($name, $value, $maxSize)
    {
        if (strlen($value) > $maxSize) {
            return 'Le champ ' . $name . ' doit contenir au maximum ' . $maxSize . ' caractères';
        }
    }
    public function repeatPassword($name, $value, $maxSize)
    {
        if ($value != $maxSize) {
            return 'Les mot de passe ne sont pas identique';
        }
    }
    public function email($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email '$value' est considérée comme invalide.";
        }
    }
}
