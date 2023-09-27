<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Core\View;

class Posts
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

        // Fetch posts
        $postModel = Post::createInstance();
        $posts = $postModel->getAllPosts();

        $activeTab = 'posts'; // Changed from 'categories' to 'posts'
        $view = new View("Dashboard/posts", "back"); // Changed from 'Dashboard/categories' to 'Dashboard/posts'
        $view->assign("role", $role);
        $view->assign("categories", $categories);
        $view->assign("posts", $posts); // Added this line to pass posts to the view
        $view->assign("activeTab", $activeTab);
    }

    public function show($params)
    {
        $postId = $params['id'];
        $postModel = Post::createInstance();
        $commentModel = Comment::createInstance();

        $post = $postModel->getPostById($postId);
        $comments = $commentModel->getCommentsByPostId($postId);

        $view = new View("Frontboard/single", "front");
        $view->assign("post", $post);
        $view->assign("comments", $comments);
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

        // Fetch categories for the dropdown
        $categoryModel = Category::createInstance();
        $categories = $categoryModel->getAllCategories();

        $activeTab = 'posts';
        $view = new View("Posts/add", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("categories", $categories);  // Pass categories to the view
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

        // Validate and sanitize input
        $title = $_POST['title'];  // You'd actually validate and sanitize this
        $content = $_POST['content'];  // You'd actually validate and sanitize this
        $category_id = $_POST['category_id'];  // You'd actually validate and sanitize this

        // Create new Post
        $post = Post::createInstance();
        $post->setTitle($title);
        $post->setContent($content);
        $post->setCategoryId($category_id);
        $post->setUserId($_SESSION['user_id']);  // Set the user_id from the session

        $result = $post->createPost($title, $content, $_SESSION['user_id'], $category_id);

        if ($result) {
            header("Location: /dashboard/posts?success=posts_created");
        } else {
            header("Location: /dashboard/posts?error=posts_not_created");
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

        $categoryModel = Category::createInstance();
        $categories = $categoryModel->getAllCategories();

        $postToUpdate = Post::createInstance();
        $postToUpdate->loadById($id);

        $activeTab = 'categories';
        $view = new View("Posts/update", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("post", $postToUpdate);
        $view->assign("categories", $categories);
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

        // Fetch the updated details from the form
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category_id = $_POST['category_id'];

        // Update the post in the database
        $post = Post::createInstance();
        $post->loadById($id);
        $post->setTitle($title);
        $post->setContent($content);
        $post->setCategoryId($category_id);

        // Assuming you have an updatePost method in your Post model
        $result = $post->updatePost($id, $title, $content, $_SESSION['user_id'], $category_id);

        if ($result) {
            header("Location: /dashboard/posts?success=posts_updated");
        } else {
            header("Location: /dashboard/posts/edit/$id?error=posts_not_updated");
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

        $post = Post::createInstance();
        $post->loadById($id);
        $result = $post->delete();

        if ($result) {
            header("Location: /dashboard/posts?success=posts_deleted");
        } else {
            header("Location: /dashboard/posts?error=posts_not_deleted");
        }
    }
}
