<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class AdminController
 * Panel admin
 * @package App\Controller
 */
class AdminController extends BaseController
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
        $pagination = $this->paginate(null);

        $allPosts = ModelFactory::getModel("Post")->listPosts($pagination['first'], $pagination['perPage'], null);
        $allComments = ModelFactory::getModel("Comment")->listComments();

        return $this->twig->render("admin/home.html.twig", [
            "allPosts" => $allPosts,
            "allComments" => $allComments,
        ]);
    }
}
