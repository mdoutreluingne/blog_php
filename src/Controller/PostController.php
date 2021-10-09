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
                return $this->delete();
                break;
            case $action == 'read':
                return $this->read();
                break;
            default :
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
        //Check permission
        $this->isAdmin();
        
        $post = filter_input_array(INPUT_POST);

        if (isset($post['submit'])) {
            $title = htmlspecialchars($post['title']);
            $chapo = htmlspecialchars($post['chapo']);
            $content = htmlspecialchars($post['content']);
            $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date = $date->format('Y-m-d H:i:s');
            /* var_dump($_FILES['picture']);
            die; */
            if (isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                $picture = $this->uploadImg("post", $_FILES['picture']);
            }

            $array = [
                'user_id' => $this->session['user']['id'],
                'title' => $title,
                'created_at' => $date,
                'updated_at' => $date,
                'chapo' => $chapo,
                'content' => $content,
                'picture' => $picture,
            ];

            ModelFactory::getModel('Post')->createData($array);

            $this->redirect('admin', ['success' => true]);
        }

        return $this->twig->render("post/create.html.twig");
    }

    /**
     * read
     *
     * @return void
     */
    private function read()
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

    /**
     * update
     *
     * @return void
     */
    private function update()
    {
        //Check permission
        $this->isAdmin();

        $post = filter_input_array(INPUT_POST);
        $idPost = filter_input(INPUT_GET, 'id');
        $postById = ModelFactory::getModel("Post")->findPostById($idPost);

        if (isset($post['submit'])) {
            $title = htmlspecialchars($post['title']);
            $chapo = htmlspecialchars($post['chapo']);
            $content = htmlspecialchars($post['content']);
            $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date = $date->format('Y-m-d H:i:s');
            $picture = $_FILES['picture']['name'] !== "" ? $this->uploadImg("post", $_FILES['picture']) : $postById[0]['picture'];

            ModelFactory::getModel('Post')->updateData($idPost, ["title" => $title, "updated_at" => $date, "chapo" => $chapo, "content" => $content, "picture" => $picture], ["id" => $idPost]);

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
        //Check permission
        $this->isAdmin();

        $idPost = filter_input(INPUT_GET, 'id');
        ModelFactory::getModel('Post')->deleteData('id', ['id' => $idPost]);

        $this->redirect('admin', ['success' => true]);
    }
}
