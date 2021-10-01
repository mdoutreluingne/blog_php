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
            'successContact' => $this->isFormSuccess(),
            'errorContact' => $this->isFormError(),
        ]);
    }

    /**
     * isFormSuccess
     *
     * @return void
     */
    public function isFormSuccess()
    {
        $success = filter_input(INPUT_GET, 'success');
        if (isset($success)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * isFormError
     *
     * @return void
     */
    public function isFormError()
    {
        $error = filter_input(INPUT_GET, 'error');
        if (isset($error)) {
            return $error;
        }

        return false;
    }
}
