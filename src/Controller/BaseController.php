<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Model\Factory\ModelFactory;

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

    /**
     * isFormError
     *
     * @return array
     */
    protected function paginate(?string $search): array
    {
        $data = [];
        
        //Get current page url
        $page = filter_input(INPUT_GET, 'page');
        //Number of post each page
        $data['perPage'] = 4;

        //We determine on which page
        if (isset($page) == true) {
            $data['currentPage'] = (int) strip_tags($page);
        } else {
            $data['currentPage'] = 1;
        }

        $countPosts = ModelFactory::getModel("Post")->countPost($search);

        //Calcul total pages
        $data['pages'] = ceil((int) $countPosts[0]['count_posts'] / $data['perPage']);

        //Calcul first post in the page
        $data['first'] = ($data['currentPage'] * $data['perPage']) - $data['perPage'];

        return $data;
    }    
}
