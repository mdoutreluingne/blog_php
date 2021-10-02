<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class PostController
 * Manages the post
 * @package App\Controller
 */
class PostController extends BaseController
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
        $post = ModelFactory::getModel("Post")->findPostById($_GET['id']);
        $comments = ModelFactory::getModel("Comment")->findComentByPost($_GET['id']);
        $countCommentByPost = ModelFactory::getModel("Comment")->countCommentByPost($_GET['id']);
        $lastPosts = ModelFactory::getModel("Post")->listLastPosts();
        
        return $this->twig->render("post/post.html.twig", [
            "post" => $post,
            "comments" => $comments,
            "countComment" => $countCommentByPost,
            "lastPosts" => $lastPosts,
        ]);
    }
}
