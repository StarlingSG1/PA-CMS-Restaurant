<?php

/**
 * PHP version 8.1
 */
namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Core\OAuth;
use App\Model\User as UserModel;

/**
 * User Controller
 * 
 * @category Controller
 * 
 * @package App\Controller
 * 
 * @access public
 * 
 * @author PACMS <pa.cms.test@gmail.com>
 */
class User
{
    /**
     * Login page
     *
     * @return void
     */
    public function login(): void
    {
        $user = new UserModel();

        // if (!empty($_POST)) {
        //     Verificator::checkForm($user->getLoginForm(), $_POST + $_FILES);
        // }


        // $user->setEmail("vivian.fr@free.fr");
        // $user->setPassword("Test1234");
        // $user->setLastname("Ruhlmann");
        // $user->setFirstname("Vivian");
        // $user->generateToken();
        // $user->save();

        // if (!empty($_POST)) {
        //     $result = Verificator::checkForm($user->getLoginForm(), $_POST + $_FILES);

        //     print_r($result);
        // }

        $view = new View("login");
        $view->assign("title", "Connexion");
        $view->assign("user", $user);
    }

    /**
     * Register page
     *
     * @return void
     */
    public function register():void
    {
        $user = new UserModel();
        $errors = null;
        $_POST = array_map('htmlspecialchars', $_POST);
        if (!empty($_POST)) {
            $errors = Verificator::checkForm($user->getCompleteRegisterForm(), $_POST + $_FILES);

            if (!$errors) {
                $user->hydrate($_POST);
                $user->setRole('user');
                $user->save();
                /////////// redirection vers le dashboard à faire
            }
        }

        $view = new View("register");
        $view->assign("user", $user);
        $view->assign("errors", $errors);
    }

    /**
     * Verify user token
     * 
     * @return void
     */
    public function verifyToken(): void
    {
        $user = new UserModel();
        $actualDateTime = new \DateTime();
        $date = new \DateTime($_GET["date"]);
        $interval = $actualDateTime->diff($date);
        $minutes = $interval->format('%i');

        if (isset($_GET["email"]) && isset($_GET["token"]) && $minutes < 10) {
            $user->verifyToken($_GET["email"], $_GET["token"]);
            header('Location: /login');
        } else {
            if (!isset($_GET["email"]) && !isset($_GET["token"])) {
                echo "L'email ou le token est null! Vérification impossible";
            } else {
                echo "Le lien n'est plus valide";
            }
        }
    }

    /**
     * Send token to user
     * 
     * @deprecated
     *
     * @return void
     */
    public function createToken(): void
    {

        $view = new View("token");
        //$view->assign("user", $user);
    }

    /**
     * Retrieve user token
     * 
     * @return void
     */
    public function getToken(): void
    {
        $user = new UserModel();
        //$user->setId(1);
        $user->setEmail("thibautsembeni@gmail.com");
        $user->setPassword("Test1234");
        $user->setLastname("SembEnI   ");
        $user->setFirstname("  THIBaut   ");
        $user->generateToken();
        Mail::sendConfirmMail($user->getToken(), $user->getEmail());
        //$user->save();
        echo "<pre>";
        echo ("Token créé " . $user->getToken());

        //envoie du mail
        //click sur http://localhost/verifyToken?token=<token>?email=<email>
    }

    /**
     * Verify if user exists
     * 
     * @return void
     */
    public function loginVerify(): void
    {
        $user = new UserModel();
        $_POST = array_map('htmlspecialchars', $_POST);


        if (!empty($_POST)) {
            Verificator::checkForm(
                $user->getLoginForm(),
                $_POST + $_FILES
            );
        }
 
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);

        $params = ["email" => $_POST['email']];

        $user->verifyUser($params);
        
        
        $view = new View("loginVerify");
        $view->assign("title", "Vérification");
        $view->assign("user", $user);
    }

    /**
     * Google login
     * 
     * @return void
     */
    public function googleConnect(): void
    {
        $token = new OAuth($_GET['code']);
        $info = $token->google();
        $user = new UserModel();

        if (!$user->findOneBy(['email' => $info->email])) {
            $user->setFirstname($info->given_name);
            $user->setLastname($info->family_name);
            $user->setEmail($info->email);
            $user->setStatus(true);
            $user->save();
        }

        new View('dashboard');
    }

    /**
     * Facebook login
     * 
     * @return void
     */
    public function facebookConnect(): void
    {
        $token = new OAuth($_GET['code']);
        $info = $token->facebook();
        $user = new UserModel();

        if (!$user->findOneBy(['email' => $info->email])) {
            $user->setFirstname($info->first_name);
            $user->setLastname($info->last_name);
            $user->setEmail($info->email);
            $user->setStatus(true);
            $user->save();
        }

        new View('dashboard');
    }

    /**
     * Lost password page
     * 
     * @return void
     */
    public function lostPassword(): void
    {
        $user = new UserModel();

        $view = new View("lostPassword");
        $view->assign("title", "Mot de passe oublié");
        $view->assign("user", $user);
    }

    /**
     * Lost password action page
     * 
     * @deprecated
     * 
     * @return void
     */
    public function lostPasswordAction(): void
    {
        $user = new UserModel();

        $view = new View("lostPasswordAction");
        $view->assign("title", "Mail d'oubli de mdp");
        $view->assign("user", $user);
      
        // if (!empty($_POST)) {
        //     Verificator::checkForm(
        //         $user->getLoginForm(),
        //         $_POST + $_FILES
        //     );
        // }

        // $email = $_POST['email'];
    }

    /**
     * Reset password page
     * 
     * @return void
     */
    public function resetPassword(): void
    {
        $user = new UserModel();

        $actualDateTime = new \DateTime();
        $date = new \DateTime($_GET["date"]);
        $interval = $actualDateTime->diff($date);
        $minutes = $interval->format('%i');

        if (isset($_GET["email"]) && isset($_GET["token"]) && $minutes < 10) {
            $user->verifyToken($_GET["email"], $_GET["token"], false);
        } else {
            if (!isset($_GET["email"]) && !isset($_GET["token"])) {
                echo "L'email ou le token est null! Vérification impossible";
            } else {
                echo "Le lien n'est plus valide";
            }
        }

        $view = new View("resetPassword");
        $view->assign("title", "Réinitialisation du mot de passe");
        $view->assign("user", $user);
    }

    /**
     * Reset password action
     * 
     * @return void
     */
    public function resetPasswordAction(): void
    {

        $user = new UserModel();
        $_POST = array_map('htmlspecialchars', $_POST);
        if (!empty($_POST)) {
            Verificator::checkForm(
                $user->getResetPasswordForm(),
                $_POST + $_FILES
            );
            // print_r($result);
        }

        $id = $user->getIdWithEmail($_GET['email']);

        $user->setId($id);
        $user->setEmail($_GET['email']);
        $user->setPassword($_POST['password']);

        $user->save();

        new View('login');
    }

    /**
     * Logout action
     * 
     * @return void
     */
    public function logout()
    {
        session_destroy();
        header('Location: /login');
    }

}
