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
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends BaseController
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
            default:
        }
    }

    /**
     * getIdPost
     *
     * @return void
     */
    public function getIdPost()
    {
        return filter_input(INPUT_GET, 'idPost');
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        //Get data form
        $dataPost = filter_input_array(INPUT_POST);

        if (isset($dataPost['content']) && !empty($dataPost['content'])) {
            $data = [];

            $data['content'] = htmlspecialchars($dataPost['content']);
            $data['created_at'] = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $data['created_at'] = $data['created_at']->format('Y-m-d H:i:s');
            $data['validated'] = 0;
            $data['user_id'] = $this->session['user']['id'];
            $data['post_id'] = $this->getIdPost();

            //Create comment
            ModelFactory::getModel('Comment')->createData($data);

            $this->redirect('post', ['success' => true, 'action' => 'read', 'id' => $this->getIdPost()]);
        }

        $this->redirect('post', ['error' => true, 'action' => 'read', 'id' => $this->getIdPost()]);
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

        $comment = filter_input_array(INPUT_POST);
        $idComment = filter_input(INPUT_GET, 'id');
        $commentById = ModelFactory::getModel("Comment")->findCommentById($idComment);

        if (isset($comment['submit'])) {
            //Call validation class
            $errors = $this->validation->validate($comment, 'Comment');
            
            if (!$errors) {
                $content = htmlspecialchars($comment['content']);
                $validated = filter_has_var(INPUT_POST, 'validated') == true ? 1 : 0;


                ModelFactory::getModel('Comment')->updateData($idComment, ['content' => $content, 'validated' => $validated], ['id' => $idComment]);

                $this->redirect('admin', ['success' => true]);
            }

            return $this->twig->render("comment/update.html.twig", [
                'comment' => $comment,
                'errors' => $errors,
                'idComment' => $idComment,
            ]);
        }

        return $this->twig->render("comment/update.html.twig", [
            'comment' => $commentById
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
        
        $idComment = filter_input(INPUT_GET, 'id');
        ModelFactory::getModel('Comment')->deleteData('id', ['id' => $idComment]);

        $this->redirect('admin', ['success' => true]);
    }
}
