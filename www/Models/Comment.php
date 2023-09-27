<?php

namespace App\Models;

use App\Core\Sql;

class Comment extends Sql
{
    protected int $id = 0;
    protected string $content;
    protected int $user_id;
    protected int $post_id;
    protected bool $is_published = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = trim($content);
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getPostId(): int
    {
        return $this->post_id;
    }

    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    public function getIsPublished(): bool
    {
        return $this->is_published;
    }

    public function setIsPublished(bool $is_published): void
    {
        $this->is_published = $is_published;
    }

    public function loadById(int $id): void
    {
        // Similar to User.php
    }

    public function getAllComments()
    {
        $query = "SELECT c.*, p.title as post_title, CONCAT(u.firstname, ' ', u.lastname) as user_name 
              FROM esgi_comments c 
              INNER JOIN esgi_posts p ON c.post_id = p.id
              INNER JOIN esgi_user u ON c.user_id = u.id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createComment($userId, $postId, $comment)
    {
        $query = "INSERT INTO esgi_comments (user_id, post_id, content, is_published) VALUES (:user_id, :post_id, :comment, true)";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':post_id', $postId, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':comment', $comment, \PDO::PARAM_STR);
        $queryPrepared->execute();
    }

    public function updateCommentStatus($commentId, $isPublished)
    {
        $query = "UPDATE esgi_comments SET is_published = :is_published WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':is_published', $isPublished, \PDO::PARAM_BOOL);
        $queryPrepared->bindParam(':id', $commentId, \PDO::PARAM_INT);
        $queryPrepared->execute();
    }

    public function getCommentsByPostId($postId)
    {
        $query = "SELECT c.*, CONCAT(u.firstname, ' ', u.lastname) as user_name 
              FROM esgi_comments c 
              INNER JOIN esgi_user u ON c.user_id = u.id 
              WHERE c.post_id = :postId AND c.is_published = true";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':postId', $postId, \PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getCommentById($commentId)
    {
        $query = "SELECT * FROM esgi_comments WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $commentId, \PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetch(\PDO::FETCH_ASSOC);
    }


    public function deleteComment($commentId)
    {
        $query = "DELETE FROM esgi_comments WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $commentId, \PDO::PARAM_INT);
        $queryPrepared->execute();
    }


    public static function createInstance()
    {
        return new self();
    }
}
