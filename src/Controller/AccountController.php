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
 * Class AccountController
 * Manages account
 * @package App\Controller
 */
class AccountController extends BaseController
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
            case $action == 'update':
                return $this->update();
                break;
            case $action == 'password':
                return $this->changePassword();
                break;    
            default :
                break;
        }       
        
    }

    /**
     * update
     *
     * @return void
     */
    private function update()
    {
        //Check permission
        $this->isUser();

        $user = filter_input_array(INPUT_POST);

        if (isset($user['submit'])) {
            $userByEmail = ModelFactory::getModel('User')->readData($user['email'], "email");

            $last_name = htmlspecialchars($user['last_name']);
            $first_name = htmlspecialchars($user['first_name']);
            $email = htmlspecialchars($user['email']);
            $avatar = $_FILES['avatar']['name'] !== "" ? $this->uploadImg("user", $_FILES['avatar']) : $userByEmail['avatar'];

            ModelFactory::getModel('User')->updateData($this->session['user']['id'], ['last_name' => $last_name, 'first_name' => $first_name, 'email' => $email, 'avatar' => $avatar], ['id' => $this->session['user']['id']]);

            //Refresh session user
            $user['id'] = $userByEmail['id'];
            $user['role'] = $userByEmail['role'];
            $user['avatar'] = $avatar;
            $this->createSession($user);

            $this->session['user']['role'] == "ADMIN" ? $this->redirect('admin', ['success' => true]) : $this->redirect('blog');
        }

        return $this->twig->render("account/update.html.twig", [
            'user' => $this->session['user']
        ]);
    }

    /**
     * changePassword
     *
     * @return void
     */
    private function changePassword()
    {
        //Check permission
        $this->isUser();
        
        $password = filter_input_array(INPUT_POST);
        
        if (isset($password['submit'])) {

            if ($password['password'] == $password['repeatpassword']) {
                ModelFactory::getModel('User')->updateData($this->session['user']['id'], ['password' => password_hash($password['password'], PASSWORD_DEFAULT)], ['id' => $this->session['user']['id']]);

                $this->session['user']['role'] == "ADMIN" ? $this->redirect('admin', ['success' => true]) : $this->redirect('blog');
            }
        }

        return $this->twig->render("account/change_password.html.twig");
    }
}
