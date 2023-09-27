<?php

namespace App\Controllers;

// session_start();

use App\Models\User;
use App\Models\Comment;
use App\Core\View;

class Comments
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

        $commentModel = Comment::createInstance();
        $comments = $commentModel->getAllComments();

        $activeTab = 'comments';
        $view = new View("Dashboard/comments", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("comments", $comments);
    }

    public function store()
    {
        // Get the user ID and post ID from the session and form
        $userId = $_SESSION['user_id'];
        $postId = $_POST['post_id'];
        $comment = $_POST['comment'];

        // Create a new comment
        $commentModel = Comment::createInstance();
        $commentModel->createComment($userId, $postId, $comment);

        // Redirect back to the post
        header("Location: /post/" . $postId);
    }

    public function edit($params)
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

        $commentId = $params['id'];
        $commentModel = Comment::createInstance();
        $comment = $commentModel->getCommentById($commentId);
        $activeTab = 'comments';

        $view = new View("Comments/edit", "back");
        $view->assign("role", $role);
        $view->assign("activeTab", $activeTab);
        $view->assign("comment", $comment);
    }

    public function delete($params)
    {
        $commentId = $params['id'];
        $commentModel = Comment::createInstance();
        $commentModel->deleteComment($commentId);

        header('Location: /dashboard/comments');
    }
}
