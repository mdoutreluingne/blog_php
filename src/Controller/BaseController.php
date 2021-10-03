<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class BaseController
 * Manages the Main Features
 * @package App\Controller
 */
abstract class BaseController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;
    protected $session = null;

    /**
     * BaseController constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        session_start();
        $this->session = filter_var_array($_SESSION);

        $this->initTwig();
        $this->addGlobals();
    }

    /**
     * Redirects to another URL
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        $params["access"] = $page;
        header("Location: index.php?" . http_build_query($params));

        exit;
    }

    /**
     * initializes Twig
     *
     * @return void
     */
    public function initTwig()
    {
        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true,
        ));
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    /**
     * Add global variables for hte all templates
     *
     * @return void
     */
    public function addGlobals()
    {
        $this->twig->addGlobal('imgPath', "img");
        $this->twig->addGlobal('imgUsers', "img/profiles");
        $this->twig->addGlobal('imgPosts', "img/posts");
        $this->twig->addGlobal('session', $this->session);
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
