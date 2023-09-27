<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Category;
use App\Core\View;

class Categories
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $categoryModel = Category::createInstance();
        $categories = $categoryModel->getAllCategories();

        $activeTab = 'categories';
        $view = new View("Dashboard/categories", "back");
        $view->assign("role", $role);
        $view->assign("categories", $categories);
        $view->assign("activeTab", $activeTab);
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $activeTab = 'categories';
        $view = new View("Categories/add", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
    }

    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $activeTab = 'categories';
        $view = new View("Dashboard/categories", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);

        // Validate and sanitize input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

        // Create new Category
        $category = Category::createInstance();
        $category->setName($name);
        $result = $category->saveCategory(); // Assuming you have a save method in your Category model

        if ($result) {
            header("Location: /dashboard/categories?success=category_created");
        } else {
            header("Location: /dashboard/categories?error=category_not_created");
        }
    }

    public function edit($params)
    {
        $id = $params['id'];

        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $categoryToUpdate = Category::createInstance();
        $categoryToUpdate->loadById($id);

        $activeTab = 'categories';
        $view = new View("Categories/update", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("category", $categoryToUpdate);
    }

    public function update($params)
    {
        $id = $params['id'];

        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $categoryToUpdate = Category::createInstance();
        $categoryToUpdate->loadById($id);
        $categoryToUpdate->setName($name);

        $result = $categoryToUpdate->updateCategory($id, $name);

        if ($result) {
            header("Location: /dashboard/categories?success=category_updated");
        } else {
            header("Location: /dashboard/categories/edit/$id?error=category_not_updated");
        }
    }

    public function delete($params)
    {
        $id = $params['id'];

        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $user = User::getInstance();
        $user->loadById($_SESSION['user_id']);
        $role = $user->getRole();

        if ($role === 'guest' || $role === null) {
            header('HTTP/1.0 404 Not Found');
            $view = new View("Error/404", "404");
            exit();
        }

        $categoryToDelete = Category::createInstance();
        $categoryToDelete->loadById($id);
        $result = $categoryToDelete->delete();


        if ($result) {
            header("Location: /dashboard/categories?success=category_deleted");
        } else {
            header("Location: /dashboard/categories?error=category_not_deleted");
        }
    }
}
