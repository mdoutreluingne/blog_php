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
                //Get data form
                $dataPost = filter_input_array(INPUT_POST);
                //Connect user
                $this->connexion($dataPost);
            } else {
                //Logout user
                $this->logout();
            }
        }
        
        return $this->twig->render("security/login.html.twig", [
            'success' => $this->isFormSuccess(),
            'error' => $this->isFormError(),
        ]);
    }

    /**
     * Connect the user
     *
     * @return void
     */
    private function connexion(array $data)
    {
        if (
            isset($data['submit']) &&
            isset($data['email']) && !empty($data['email']) &&
            isset($data['password']) && !empty($data['password'])
        ) {
            $user = ModelFactory::getModel('User')->readData($data['email'], "email");

            if (isset($user) && !empty($user)) {
                $passwordForm = $data['password'];
                $passwordHash = $user['password'];

                if ($this->checkPassword($passwordForm, $passwordHash)) {
                    //Initialize user session
                    $this->createSession($user);
                    //Redirect user in function of his role
                    $this->session['user']['role'] == "ADMIN" ? $this->redirect('admin') : $this->redirect('blog');
                } else {
                    $this->redirect('security', ['error' => true]);
                }
            } else {
                $this->redirect('security', ['error' => true]);
            }
        } else {
            $this->redirect('security', ['error' => true]);
        }
        
    }

    /**
     * Check password user
     *
     * @param  mixed $outputPassword
     * @param  mixed $passwordHash
     *
     * @return bool
     */
    private function checkPassword($outputPassword, $passwordHash): bool
    {
        if ($outputPassword && $passwordHash) {
            return password_verify($outputPassword, $passwordHash);
        }
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
}
