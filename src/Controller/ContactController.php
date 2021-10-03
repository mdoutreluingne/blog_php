<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;

/**
 * Class ContactController
 * Manages the ContactPage
 * @package App\Controller
 */
class ContactController extends BaseController
{
    /**
     * Renders the View Contact
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        return $this->twig->render('contact/contact.html.twig', [
            'success' => $this->isFormSuccess(),
            'error' => $this->isFormError(),
        ]);
    }
}
