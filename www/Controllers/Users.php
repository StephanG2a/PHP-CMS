<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Menu;
use App\Core\View;

class Users
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            // Send a 404 error if the user is not logged in
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            // Send a 404 error if the user is a guest or role is not set
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        try {
            $users = $user->getAllUsers();
        } catch (Exception $e) {
            // Handle the error (log it, show an error message, etc.)
            die("An error occurred: " . $e->getMessage());
        }

        $activeTab = 'users';
        $view = new View("Dashboard/users", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            // Send a 404 error if the user is not logged in
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            // Send a 404 error if the user is a guest or role is not set
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        try {
            $users = $user->getAllUsers();
        } catch (Exception $e) {
            // Handle the error (log it, show an error message, etc.)
            die("An error occurred: " . $e->getMessage());
        }

        $activeTab = 'users';
        $view = new View("Users/add", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
    }

    public function store()
    {
        // Check if the user is logged in and has the role of 'admin'
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role !== 'admin') {
            header("Location: /dashboard");
            exit();
        }

        // Server-side validation
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
            header("Location: /dashboard/users/create?error=missing_fields");
            exit();
        }

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        // Check for duplicate email
        $existingUser = $user->checkDuplicateEmail($email);

        if ($existingUser) {
            header("Location: /dashboard/users/create?error=email_exists");
            exit();
        }

        // Set user properties and save
        $newUser = new User();
        $newUser->setId(0);  // Explicitly set ID to zero
        $newUser->setFirstname($firstname);
        $newUser->setLastname($lastname);
        $newUser->setEmail($email);
        $newUser->setPassword($password);  // This should hash the password
        $newUser->setStatus(true);
        $newUser->setRole($role);

        $result = $newUser->save();

        if ($result) {
            header("Location: /dashboard/users?success=user_created");
        } else {
            header("Location: /dashboard/users/create?error=user_not_created");
        }
        exit();
    }

    public function edit($params)
    {
        $id = $params['id'];
        if (!isset($_SESSION['user_id'])) {
            // Send a 404 error if the user is not logged in
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            // Send a 404 error if the user is a guest or role is not set
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        try {
            $users = $user->getAllUsers();
        } catch (Exception $e) {
            // Handle the error (log it, show an error message, etc.)
            die("An error occurred: " . $e->getMessage());
        }

        $userToUpdate = new User();
        $userToUpdate->loadById($id);

        $activeTab = 'users';
        $view = new View("Users/update", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
        $view->assign("user", $userToUpdate);
    }

    public function update($params)
    {
        $id = $params['id'];
        // Check if the user is logged in and has the role of 'admin'
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role !== 'admin') {
            header("Location: /dashboard");
            exit();
        }

        // Server-side validation
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['role'])) {
            header("Location: /dashboard/users/edit/$id?error=missing_fields");
            exit();
        }

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        // Load the user to be updated
        $userToUpdate = new User();
        $userToUpdate->loadById($id);

        // Set new properties
        $userToUpdate->setFirstname($firstname);
        $userToUpdate->setLastname($lastname);
        $userToUpdate->setEmail($email);
        $userToUpdate->setRole($role);

        // Perform the update
        $result = $userToUpdate->save();

        if ($result) {
            header("Location: /dashboard/users?success=user_updated");
        } else {
            header("Location: /dashboard/users/edit/$id?error=user_not_updated");
        }
        exit();
    }

    public function delete($params)
    {
        $userId = $params['id'];
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role !== 'admin') {
            header("Location: /dashboard");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($userId);

        // Delete tokens first
        $user->deleteTokens();

        // Now delete the user
        $user->delete();

        header('Location: /dashboard/users');
    }

    public function manage()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);

        $menuModel = Menu::createInstance();
        $menus = $menuModel->getAllMenus();

        $view = new View("Frontboard/edit", "front");
        $view->assign("user", $user);
        $view->assign("menus", $menus);
    }

    public function updateProfile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }

        // Get user input
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); // You may want to hash this before storing

        // Load user from database
        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);

        // Update user properties
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT)); // Hash the password before storing

        // Save updated user back to database
        if ($user->update()) {
            // Redirect to profile page with success message
            header('Location: /?update=success');
        } else {
            // Redirect to profile page with error message
            header('Location: /?update=error');
        }

        exit();
    }
}
