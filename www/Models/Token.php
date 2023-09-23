<?php

namespace App\Models;

use App\Core\Sql;

class Token extends Sql
{
    protected int $id;
    protected int $user_id;
    protected string $token;
    protected string $expires_at;
    protected string $type;
    protected string $created_at;
    protected string $updated_at;

    // Getters and setters for each property

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }

    public function setExpiresAt(string $expires_at): void
    {
        $this->expires_at = $expires_at;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
