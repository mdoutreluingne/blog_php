<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
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
        $action = filter_input(INPUT_GET, 'action');
        
        switch (isset($action)) {
            case $action == 'create':
                return $this->create();     
                break;
            case $action == 'update':
                return $this->update();
                break;
            case $action == 'delete':
                $this->delete();
                break;
            default :
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

                break;
        }
        
        
    }

    /**
     * saveSessionPost
     *
     * @return void
     */
    public function saveSessionPost(int $id)
    {
        $this->session['post']['id'] = $id;

        $_SESSION['post'] = $this->session['post'];
    }

    /**
     * Create post
     *
     * @return void
     */
    private function create()
    {
        $post = filter_input_array(INPUT_POST);

        if (isset($post['submit'])) {
            $title = htmlspecialchars($post['title']);
            $chapo = htmlspecialchars($post['chapo']);
            $content = htmlspecialchars($post['content']);
            $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date = $date->format('Y-m-d H:i:s');
            //$mainImagePath = 'assets/img/posts_images/' . self::getId() . '/' . $post['mainImg']['image']['name'];

            $array = [
                'user_id' => $this->session['user']['id'],
                'title' => $title,
                'created_at' => $date,
                'updated_at' => $date,
                'chapo' => $chapo,
                'content' => $content,
                //'main_img_path' => $mainImagePath,
            ];

            ModelFactory::getModel('Post')->createData($array);

            $this->redirect('admin', ['success' => true]);
        }

        return $this->twig->render("post/create.html.twig");
    }

    /**
     * update
     *
     * @return void
     */
    private function update()
    {
        $post = filter_input_array(INPUT_POST);
        $idPost = filter_input(INPUT_GET, 'id');
        $postById = ModelFactory::getModel("Post")->findPostById($idPost);

        if (isset($post['submit'])) {
            $title = htmlspecialchars($post['title']);
            $chapo = htmlspecialchars($post['chapo']);
            $content = htmlspecialchars($post['content']);
            $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date = $date->format('Y-m-d H:i:s');
            //$mainImagePath = 'assets/img/posts_images/' . self::getId() . '/' . $post['mainImg']['image']['name'];

            ModelFactory::getModel('Post')->updateData($idPost, ['title' => $title, 'updated_at' => $date, 'chapo' => $chapo, 'content' => $content], ['id' => $idPost]);

            $this->redirect('admin', ['success' => true]);
        }

        return $this->twig->render("post/update.html.twig", [
            'post' => $postById
        ]);
    }

    /**
     * delete
     *
     * @return void
     */
    private function delete()
    {
        $idPost = filter_input(INPUT_GET, 'id');
        ModelFactory::getModel('Post')->deleteData('id', ['id' => $idPost]);

        $this->redirect('admin', ['success' => true]);
    }
}
