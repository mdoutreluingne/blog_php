<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends BaseController
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
        $type = filter_input(INPUT_GET, 'type');

        if (isset($type) && !empty($type)) {
            if ($type == "login") {
                //Connect user
                return $this->connexion();
            }

            //Logout user
            $this->logout();
        }       
        
    }

    /**
     * Connect the user
     *
     * @return void
     */
    private function connexion()
    {
        //Get data form
        $data = filter_input_array(INPUT_POST);

        if (isset($data['submit'])) {

            //Call validation class
            $errors = $this->validation->validate($data, 'Security');

            if (!$errors) {
                $user = ModelFactory::getModel('User')->readData($data['email'], "email");

                $this->checkUserExist($data, $user);
            }

            return $this->twig->render("security/login.html.twig", [
                'data' => $data,
                'errors' => $errors,
                'success' => $this->isFormSuccess(),
                'error' => $this->isFormError(),
            ]);

        }

        return $this->twig->render("security/login.html.twig", [
            'success' => $this->isFormSuccess(),
            'error' => $this->isFormError(),
        ]);
        
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
        $this->redirect('home');
    }

    /**
     * Check password user
     *
     * @param  mixed $outputPassword
     * @param  mixed $passwordHash
     *
     * @return void
     */
    private function checkPassword($outputPassword, $passwordHash, array $user): void
    {
        if (password_verify($outputPassword, $passwordHash)) {
            //Initialize user session
            $this->createSession($user);
            //Redirect user in function of his role
            $this->session['user']['role'] == "ADMIN" ? $this->redirect('admin') : $this->redirect('blog');
        } else {
            $this->redirect('security', ['error' => true, 'type' => 'login']);
        }
    }

    /**
     * checkUserExist
     *
     * @param array $data
     * @param array $user
     * @return void
     */
    private function checkUserExist(array $data, array $user): void
    {
        if (isset($user)) {
            $passwordForm = $data['password'];
            $passwordHash = $user['password'];

            $this->checkPassword($passwordForm, $passwordHash, $user);
        } else {
            $this->redirect('security', ['error' => true, 'type' => 'login']);
        }
    }
}
