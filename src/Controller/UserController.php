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
 * Class UserController
 * Manages the user
 * @package App\Controller
 */
class UserController extends BaseController
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
            default :
        }
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

        $userData = filter_input_array(INPUT_POST);

        //Submit form
        if (isset($userData['submit'])) {

            //Test all the fields
            if (
                isset($userData['firstname']) && !empty($userData['firstname']) &&
                isset($userData['lastname']) && !empty($userData['lastname']) &&
                isset($userData['email']) && !empty($userData['email']) &&
                isset($userData['password']) && !empty($userData['password']) &&
                isset($userData['repeatpassword']) && !empty($userData['repeatpassword']) &&
                isset($userData['role'])
            ) {
                //The passwords are the same
                if ($userData['password'] == $userData['repeatpassword']) {
                    $user = ModelFactory::getModel('User')->readData($userData['email'], "email");

                    if (isset($user) && empty($user)
                    ) {
                        //Get data form
                        $data = [];
                        $data['first_name'] = $userData['firstname'];
                        $data['last_name'] = $userData['lastname'];
                        $data['email'] = $userData['email'];
                        $data['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
                        $data['role'] = $userData['role'];

                        ModelFactory::getModel('User')->createData($data);

                        $this->redirect('admin', ['success' => true]);
                    } else {
                        $this->redirect('admin', ['error' => true]);
                    }
                } else {
                    $this->redirect('admin', ['error' => true]);
                }
            } else {
                $this->redirect('admin', ['error' => true]);
            }
        }

        return $this->twig->render("user/create.html.twig");
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

        $userData = filter_input_array(INPUT_POST);
        $idUser = filter_input(INPUT_GET, 'id');
        $userById = ModelFactory::getModel('User')->readData($idUser, "id");

        if (isset($userData['submit'])) {

            $last_name = htmlspecialchars($userData['lastname']);
            $first_name = htmlspecialchars($userData['firstname']);
            $email = htmlspecialchars($userData['email']);
            $role = $userData['role'];
            $password = $userData['password'] !== "" ? password_hash($userData['password'], PASSWORD_DEFAULT) : $userById['password'];

            ModelFactory::getModel('User')->updateData($idUser, ['last_name' => $last_name, 'first_name' => $first_name, 'email' => $email, 'password' => $password, 'role' => $role], ['id' => $idUser]);

            $this->redirect('admin', ['success' => true]);
        }

        return $this->twig->render("user/update.html.twig", [
            'user' => $userById
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

        $idUser = filter_input(INPUT_GET, 'id');
        ModelFactory::getModel('User')->deleteData('id', ['id' => $idUser]);

        $this->redirect('admin', ['success' => true]);
    }
}
