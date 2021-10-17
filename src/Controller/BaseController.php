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
    protected $files = null;
    protected $validation;

    /**
     * BaseController constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        session_start();
        $this->session = filter_var_array($_SESSION);
        $this->files = filter_var_array($_FILES);
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
        //Test if the image has no error and less than 1 Mo
        if (isset($picture['name']) && $picture['error'] == 0 && $picture['size'] <= 1000000) {
            //Let's test if the extension is allowed
            $extension_upload = pathinfo($picture['name'], PATHINFO_EXTENSION);
            $extensions_autorisees = ['jpg', 'jpeg', 'png'];

            if (in_array($extension_upload, $extensions_autorisees)) {
                //Storage file in function of the type
                return $this->storageFile($type, $picture, $extension_upload);
            }  
        }
    }

    /**
     * storageFile
     *
     * @param string $type
     * @param array $picture
     * @param string $extension_upload
     * @return string
     */
    private function storageFile(string $type, array $picture, string $extension_upload): string
    {
        //Generate a unique name for the picture
        $pictureName = basename(md5(uniqid()) . '.' . $extension_upload);

        switch ($type) {
            case 'post' == $type:
                //We can storage picture in the folder
                move_uploaded_file($picture['tmp_name'], 'img/posts/' . $pictureName);

                return $pictureName;
                break;
            case 'user' == $type:
                //We can storage picture in the folder
                move_uploaded_file($picture['tmp_name'], 'img/avatar/' . $pictureName);

                return $pictureName;
                break;
            default:
        }
    }

    protected function validateCreateUser(array $data)
    {
        return $this->validation->validate($data, 'Registration');
    }
}
