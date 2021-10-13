<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use App\Model\Factory\ModelFactory;

/**
 * Class RegistrationController
 * Register user
 * @package App\Controller
 */
class RegistrationController extends BaseController
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
        $dataPost = filter_input_array(INPUT_POST);

        //Submit form
        if (isset($dataPost['submit'])) {

            //Call validation class
            $errors = $this->validation->validate($dataPost, 'Registration');

            if (!$errors) {
                $user = ModelFactory::getModel('User')->readData($dataPost['email'], "email");

                if (isset($user) && empty($user)) {
                    //Get data form
                    $data = [];
                    $data['first_name'] = $dataPost['firstname'];
                    $data['last_name'] = $dataPost['lastname'];
                    $data['email'] = $dataPost['email'];
                    $data['password'] = password_hash($dataPost['password'], PASSWORD_DEFAULT);
                    $data['role'] = "USER";

                    ModelFactory::getModel('User')->createData($data);

                    $this->redirect('security', ['success' => true, 'type' => 'login']);
                } else {
                    $this->redirect('registration', ['error' => true]);
                }
            }

            return $this->twig->render("registration/register.html.twig", [
                'data' => $dataPost,
                'errors' => $errors,
                'error' => $this->isFormError(),
            ]);
        }
        
        return $this->twig->render("registration/register.html.twig", [
            'error' => $this->isFormError(),
        ]);
    }
}
