<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Constraint\Validation;
use App\Model\Factory\ModelFactory;

/**
 * Class BaseController
 * Manages the Main Features
 * @package App\Controller
 */
abstract class BaseController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;
    protected $session = null;
    protected $validation;

    /**
     * BaseController constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        session_start();
        $this->session = filter_var_array($_SESSION);
        $this->validation = new Validation();

        $this->initTwig();
        $this->addGlobals();
    }

    /**
     * Redirects to another URL
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        $params["access"] = $page;
        header("Location: index.php?" . http_build_query($params));

        exit;
    }

    /**
     * initializes Twig
     *
     * @return void
     */
    public function initTwig()
    {
        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true,
        ));
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    /**
     * Add global variables for hte all templates
     *
     * @return void
     */
    public function addGlobals()
    {
        $this->twig->addGlobal('imgPath', "img");
        $this->twig->addGlobal('imgUsers', "img/avatar");
        $this->twig->addGlobal('imgPosts', "img/posts");
        $this->twig->addGlobal('session', $this->session);
    }

    /**
     * Test if user possesses ADMIN role 
     *
     * @return void
     */
    protected function isAdmin()
    {
        if ($this->getUserSession() != null && $this->getUserSession()['role'] == "ADMIN") {
            return true;
        }

        return $this->redirect('home');
    }

    /**
     * Test if user possesses USER role 
     *
     * @return void
     */
    protected function isUser()
    {
        if ($this->getUserSession() != null && $this->getUserSession()['role'] == "USER") {
            return true;
        } elseif ($this->getUserSession() != null && $this->getUserSession()['role'] == "ADMIN") {
            return true;
        }

        return $this->redirect('home');
    }

    /**
     * getUserSession
     *
     * @return void
     */
    protected function getUserSession()
    {
        return $this->session['user'];
    }

    /**
     * isFormSuccess
     *
     * @return void
     */
    public function isFormSuccess()
    {
        $success = filter_input(INPUT_GET, 'success');
        if (isset($success)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * isFormError
     *
     * @return void
     */
    public function isFormError()
    {
        $error = filter_input(INPUT_GET, 'error');
        if (isset($error)) {
            return $error;
        }

        return false;
    }

    /**
     * Create session
     *
     * @param  mixed $user
     *
     * @return void
     */
    protected function createSession($user)
    {
        $this->session['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'avatar' => $user['avatar'],
        ];

        $_SESSION['user'] = $this->session['user'];
    }

    /**
     * isFormError
     *
     * @return array
     */
    protected function paginate(?string $search): array
    {
        $data = [];
        
        //Get current page url
        $page = filter_input(INPUT_GET, 'page');
        //Number of post each page
        $data['perPage'] = 4;

        //We determine on which page
        if (isset($page) == true) {
            $data['currentPage'] = (int) strip_tags($page);
        } else {
            $data['currentPage'] = 1;
        }

        $countPosts = ModelFactory::getModel("Post")->countPost($search);

        //Calcul total pages
        $data['pages'] = ceil((int) $countPosts[0]['count_posts'] / $data['perPage']);

        //Calcul first post in the page
        $data['first'] = ($data['currentPage'] * $data['perPage']) - $data['perPage'];

        return $data;
    }

    /**
     * uploadImg
     *
     * @return void
     */
    protected function uploadImg(string $type, array $picture)
    {
        switch ($type) {
            case $type == 'post':
                if (isset($picture['name']) and !empty($picture['name']) and $picture['error'] == 0) {

                    // Testons si le fichier n'est pas trop gros
                    if ($picture['size'] <= 1000000) {
                        // Testons si l'extension est autorisée
                        $extension_upload = pathinfo($picture['name'], PATHINFO_EXTENSION);
                        $extensions_autorisees = array('jpg', 'jpeg', 'png');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            //Generate a unique name for the picture
                            $pictureName = basename(md5(uniqid()) . '.' . $extension_upload);
                            // On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($picture['tmp_name'], 'img/posts/' . $pictureName);

                            return $pictureName;
                        }
                    }
                }
                break;
            case $type == 'user':
                if (isset($picture['name']) and $picture['error'] == 0) {

                    // Testons si le fichier n'est pas trop gros
                    if ($picture['size'] <= 1000000) {
                        // Testons si l'extension est autorisée
                        $extension_upload = pathinfo($picture['name'], PATHINFO_EXTENSION);
                        $extensions_autorisees = array('jpg', 'jpeg', 'png');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            //Generate a unique name for the picture
                            $pictureName = basename(md5(uniqid()) . '.' . $extension_upload);
                            // On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($picture['tmp_name'], 'img/avatar/' . $pictureName);

                            return $pictureName;
                        }
                    }
                }
                break;
            default:
                break;
        }
    }
}
