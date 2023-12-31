<?php

namespace App\Controllers;

// session_start();

use App\Core\View;
use App\Forms\AddUser;
use App\Models\User;
use App\Models\Token;
use App\Core\Verificator;
use App\Forms\LoginForm;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Security
{
    public function login(): void
    {
        $form = new LoginForm();
        $view = new View("Auth/login", "login");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $errors = Verificator::form($form->getConfig(), $_POST);

            if (empty($errors)) {
                $user = User::getInstance();
                $authenticatedUser = $user->checkUserCredentials($_POST['email'], $_POST['password']);

                if ($authenticatedUser) {
                    if ($authenticatedUser['status']) {
                        // User is authenticated and email is verified, proceed with login
                        $_SESSION['user_id'] = $authenticatedUser['id'];
                        // Set session or whatever you do to log in
                        $user->setId($authenticatedUser['id']);
                        $user->setFirstname($authenticatedUser['firstname']);
                        $user->setLastname($authenticatedUser['lastname']);
                        $user->setEmail($authenticatedUser['email']);
                        $user->setStatus($authenticatedUser['status']);
                        $user->setRole($authenticatedUser['role']);
                        header('Location: /');
                    } else {
                        // User is authenticated but email is not verified
                        $errors[] = "Please verify your email before logging in.";
                    }
                } else {
                    // Authentication failed
                    $errors[] = "Invalid email or password";
                }
            }

            if (!empty($errors)) {
                $view->assign('errors', $errors);
            }
        }
    }


    public function register(): void
    {
        $form = new AddUser();
        $view = new View("Auth/register", "register");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $errors = Verificator::form($form->getConfig(), $_POST);

            if (empty($errors)) {
                // Get the User singleton instance
                $user = User::getInstance();

                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                // Check for duplicate email
                $existingUser = $user->checkDuplicateEmail($email);
                if ($existingUser) {
                    // Handle error properly
                    die("This email is already registered. Please use a different email.");
                }

                // Set user properties
                $user->setFirstname(filter_var($_POST['firstname'], FILTER_SANITIZE_STRING));
                $user->setLastname(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING));
                $user->setEmail($email);
                $user->setPassword($_POST['pwd']);
                $user->setStatus(false); // false because the user needs to verify their email
                $user->setRole('guest'); // Set role to 'guest' by default
                // Save the user to the database
                $user->save();

                // Generate token and save to database

                $tokenModel = Token::getInstance();
                $token = bin2hex(random_bytes(50));
                $expires_at = new \DateTime('+1 day', new \DateTimeZone('Europe/Paris'));

                if ($user->createToken($user->getId(), $token, $expires_at, 'email_verification')) {
                    include 'PHPMAILER/Exception.php';
                    include 'PHPMAILER/PHPMailer.php';
                    include 'PHPMAILER/SMTP.php';
                    $mail = new PHPMailer(true);

                    // ... (Your SMTP settings here)
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host       = 'smtp.gmail.com';               // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
                    $mail->Username   = 'stephan.gueorguieff@gmail.com';         // SMTP username
                    $mail->Password   = 'ywbbjgjipggrwmgc';            // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    // Recipients
                    $mail->addAddress($user->getEmail());

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Account Verification';
                    $mail->Body    = "Click the link to verify your account: http://stephan.stephancms.com:8081/verify?token=$token";

                    try {
                        $mail->send();
                        echo "A verification email has been sent to your email address.";
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    // Handle error properly
                    die("Could not create token.");
                }
            } else {
                $view->assign('errors', $errors);
            }
        }
    }

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? null;

        if ($token) {
            $sql = User::getInstance();  // Assuming User extends Sql
            $userId = $sql->verifyTokenForUser($token, 'email_verification');

            if ($userId) {
                $user = User::getInstance();
                $user->loadById($userId);  // Assuming you have a loadById method
                $user->setStatus(true);  // Assuming setStatus updates the email verification status
                $user->save();
                echo "Email verified successfully.";
                header('Location: /login');
            } else {
                echo "Invalid or expired token.";
            }
        } else {
            echo "No token provided.";
        }
    }

    public function logout(): void
    {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the homepage or login page
        header('Location: /login');
        exit();
    }
}
