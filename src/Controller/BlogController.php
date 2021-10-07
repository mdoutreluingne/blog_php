<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class BlogController
 * Manages the all the posts
 * @package App\Controller
 */
class BlogController extends BaseController
{
    /**
     * Renders the View Blog
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        //Get data search form
        $search = filter_input(INPUT_POST, 'search');
        $search = htmlspecialchars($search);

        $pagination = $this->paginate($search);

        $allPosts = ModelFactory::getModel("Post")->listPosts($pagination['first'], $pagination['perPage'], $search);
        $lastPosts = ModelFactory::getModel("Post")->listLastPosts();

        return $this->twig->render("blog/blog.html.twig", [
            "allPosts" => $allPosts,
            "lastPosts" => $lastPosts,
            "currentPage" => $pagination['currentPage'],
            "pages" => $pagination['pages'],
            'search' => $search
        ]);
    }
}
