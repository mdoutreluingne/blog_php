<?php

namespace App\Controller;

use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Controller\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class MailController
 * Check if form contact is OK and send mail
 * @package App\Controller
 */
class MailController extends BaseController
{
    /**
     * Check if form contact is OK and send mail
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $this->sendEmail();
    }

    public function sendEmail()
    {
        //Get config server SMTP
        require_once "../config/mailer.php";

        $dataPost = filter_input_array(INPUT_POST);

        $firstname = $dataPost['firstname'];
        $lastname = $dataPost['lastname'];
        $email = $dataPost['email'];
        $message = $dataPost['message'];

        if (isset($firstname) && !empty($firstname) &&
            isset($lastname) && !empty($lastname) &&
            isset($email) && !empty($email) &&
            isset($message) && !empty($message)
        ) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer();

            try {
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
        } else {
            //Redirect to contact page && error
            $this->redirect('contact', ['error' => true]);
        }
        
    }
}
