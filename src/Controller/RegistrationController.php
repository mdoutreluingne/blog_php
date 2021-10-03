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

            //Test all the fields
            if (
                isset($dataPost['firstname']) && !empty($dataPost['firstname']) &&
                isset($dataPost['lastname']) && !empty($dataPost['lastname']) &&
                isset($dataPost['email']) && !empty($dataPost['email']) &&
                isset($dataPost['password']) && !empty($dataPost['password']) &&
                isset($dataPost['repeatpassword']) && !empty($dataPost['repeatpassword'])
            ) {
                //The passwords are the same
                if ($dataPost['password'] == $dataPost['repeatpassword']) {
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

                        $this->redirect('security', ['success' => true]);
                    } else {
                        $this->redirect('registration', ['error' => true]);
                    }
                } else {
                    $this->redirect('registration', ['error' => true]);
                }
            } else {
                $this->redirect('registration', ['error' => true]);
            }
        }
        
        return $this->twig->render("registration/register.html.twig", [
            'error' => $this->isFormError(),
        ]);
    }
}
