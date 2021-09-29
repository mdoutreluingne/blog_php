<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class HomeController
 * Manages the Homepage
 * @package App\Controller
 */
class BlogController extends BaseController
{
    /**
     * Renders the View Home
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allPosts = ModelFactory::getModel("Post")->listPosts();
        $lastPosts = ModelFactory::getModel("Post")->listLastPosts();

        return $this->twig->render("blog/blog.html.twig", [
            "allPosts" => $allPosts,
            "lastPosts" => $lastPosts
        ]);
    }
}
