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
        $postId = filter_input(INPUT_GET, 'id');

        if (isset($postId) && !empty($postId)) {
            $post = ModelFactory::getModel("Post")->findPostById($postId);
            $comments = ModelFactory::getModel("Comment")->findComentByPost($postId);
            $countCommentByPost = ModelFactory::getModel("Comment")->countCommentByPost($postId);
            $lastPosts = ModelFactory::getModel("Post")->listLastPosts();
        }
        
        return $this->twig->render("post/post.html.twig", [
            'success' => $this->isFormSuccess(),
            "post" => $post,
            "comments" => $comments,
            "countComment" => $countCommentByPost,
            "lastPosts" => $lastPosts,
        ]);
    }
}
