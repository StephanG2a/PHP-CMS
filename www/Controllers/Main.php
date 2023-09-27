<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Core\View;

class Main
{
    public function index()
    {
        $postModel = Post::createInstance();
        $categoryModel = Category::createInstance();

        $categoryName = $_GET['category'] ?? null;
        $categories = $categoryModel->getAllCategories();

        if ($categoryName && $categoryName !== 'all') {
            $posts = $postModel->getPostsByCategoryName($categoryName);
        } else {
            $posts = $postModel->getAllPosts();
        }

        $view = new View("Frontboard/blog", "front");
        $view->assign("posts", $posts);
        $view->assign("categories", $categories);
    }

    public function indexByCategory($params)
    {
        $categoryModel = Category::createInstance();
        $categories = $categoryModel->getAllCategories();
        $categoryName = strtolower($params['category']);


        $postModel = Post::createInstance();
        $posts = $postModel->getPostsByCategoryName($categoryName);

        $view = new View("Frontboard/blog", "front");
        $view->assign("posts", $posts);
        $view->assign("categories", $categories);
    }

    public function contact()
    {
        $view = new View("Main/contact", "front");
    }

    public function dashboard()
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

        $users = $user->getAllUsers();
        $userCount = count($users);

        $commentModel = Comment::createInstance();
        $comments = $commentModel->getAllComments();
        $commentCount = count($comments);

        $postModel = Post::createInstance();
        $posts = $postModel->getAllPosts();
        $postCount = count($posts);

        $categoryModel = Category::createInstance();
        $categories = $categoryModel->getAllCategories();
        $categoryCount = count($categories);

        $activeTab = 'dashboard';
        $view = new View("Dashboard/dashboard", "back");
        $view->assign("role", $role);
        $view->assign("users", $users);
        $view->assign("activeTab", $activeTab);
        $view->assign("userCount", $userCount);
        $view->assign("commentCount", $commentCount);
        $view->assign("postCount", $postCount);
        $view->assign("categoryCount", $categoryCount);
    }
}
