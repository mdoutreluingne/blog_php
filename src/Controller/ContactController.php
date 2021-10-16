<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class ContactController
 * Manages the ContactPage
 * @package App\Controller
 */
class ContactController extends BaseController
{
    /**
     * Renders the View Contact
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $data = filter_input_array(INPUT_POST);

        if (isset($data['submit'])) {

            //Call validation class
            $errors = $this->validation->validate($data, 'Contact');

            if (!$errors) {
                $this->sendEmail($data);
            }

            return $this->twig->render('contact/contact.html.twig', [
                'data' => $data,
                'errors' => $errors,
                'success' => $this->isFormSuccess(),
                'error' => $this->isFormError(),
            ]);
        }

        return $this->twig->render('contact/contact.html.twig', [
            'success' => $this->isFormSuccess(),
            'error' => $this->isFormError(),
        ]);
    }

    public function sendEmail(array $data)
    {
        //Get config server SMTP
        require_once "../config/mailer.php";

        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $message = $data['message'];

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            
            $this->configMailer($mail);

            // From
            $mail->setFrom($email, $firstname . ' ' . $lastname);
            // To
            $mail->addAddress('admin@gmail.com', 'Contact Blog - Maxime Doutreluingne');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Contact Blog';
            $mail->Body = 'Nom : ' . $lastname . '<br>Prénom : ' . $firstname . '<br>Message : ' . $message;
            $mail->AltBody = $message;

            //Send the message
            ob_start();
            $mail->send();
            ob_end_clean();

            //Redirect to contact page
            $this->redirect('contact', ['success' => true]);
        } catch (Exception $e) {
            //Redirect to contact page && error
            $this->redirect('contact', ['error' => true]);
        }
    }

    /**
     * configMailer
     *
     * @param PHPMailer $mail
     * @return void
     */
    public function configMailer(PHPMailer $mail): void
    {
        //Enable verbose debug output
        $mail->SMTPDebug = 3;

        //Encoding utf-8
        $mail->CharSet = 'UTF-8';

        //Send using SMTP
        $mail->isSMTP();

        //Server SMTP settings
        $mail->Host = HOST;
        $mail->Port = PORT;
        $mail->SMTPAuth = false;
    }
}
