<?php

namespace App\Controller;

use App\Model\LoginLogoutManager;

class LoginLogoutController extends AbstractController
{
    /**
     ** Login function
     */
    public function login(): ?string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $post = array_map('trim', $_POST);
            // Erros check
            $errors = $this->validateLogin($post);
            if (empty($errors)) {
                $email = $post['email'];
                $password = md5($post['password']);
                // So we are checking if the user exist in the database
                $loginLogoutManager = new LoginLogoutManager();
                $user = $loginLogoutManager->selectOneUser($email, $password);
                if ($user !== false) {
                    // Creation of a session variable
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'firstname' => $user['firstname'],
                        'lastname' => $user['lastname']
                    ];
                    header('Location: /');
                    return null;
                } else {
                    $errors[] = "Vos données de connexion ne correspondent à aucun utilisateur enregistré";
                }
            }
        }

        return $this->twig->render('Login/index.html.twig', [
            'loginErrors'   => $errors,
        ]);
    }

    /**
     * Form check before login the user
     */
    public function validateLogin($post): array
    {
        $errors = [];
        // is the email format correct?
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Veuillez saisir une adresse email valide';
        }
        // password check
        if (!isset($post['password']) || empty($post['password'])) {
            $errors[] = 'Veuillez renseigner votre mot de passe';
        }
        return $errors;
    }

    /**
     * Logout function
     */
    public function logout(): void
    {
        // We destroy the session variable
        session_unset();

        // We destroy the session
        session_destroy();

        header('location: /?logout');
    }
}
