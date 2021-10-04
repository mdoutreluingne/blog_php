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

        if (isset($action) && !empty($action)) {
            if ($action == "create") {
                $this->create();
            }
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

        $data = [];

        $data['content'] = htmlspecialchars($dataPost['content']);
        $data['created_at'] = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $data['created_at'] = $data['created_at']->format('Y-m-d H:i:s');
        $data['validated'] = 0;
        $data['user_id'] = $this->session['user']['id'];
        $data['post_id'] = $this->getIdPost();

        //Create comment
        ModelFactory::getModel('Comment')->createData($data);

        $this->redirect('post', ['success' => true, 'id' => $this->getIdPost()]);
    }
}
