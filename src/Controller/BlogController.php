<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class HomeController
 * Manages the all the posts
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
        $perPage = 4;
        $page = filter_input(INPUT_GET, 'page');

        //We determine on which page
        if (isset($page) == true) {
            $currentPage = (int) strip_tags($page);
        } else {
            $currentPage = 1;
        }

        $countPosts = ModelFactory::getModel("Post")->countPost();

        //Calcul total pages
        $pages = ceil((int) $countPosts[0]['count_posts'] / $perPage);

        //Calcul first post in the page
        $first = ($currentPage * $perPage) - $perPage;

        $allPosts = ModelFactory::getModel("Post")->listPosts($first, $perPage);
        $lastPosts = ModelFactory::getModel("Post")->listLastPosts();
        

        return $this->twig->render("blog/blog.html.twig", [
            "allPosts" => $allPosts,
            "lastPosts" => $lastPosts,
            "currentPage" => $currentPage,
            "pages" => $pages
        ]);
    }
}
