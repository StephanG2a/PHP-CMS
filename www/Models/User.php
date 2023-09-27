<?php

namespace App\Models;

use App\Core\Sql;

class User extends Sql
{
    protected int $id = 0;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected bool $status = false;
    protected $date_inserted;
    protected $role;

    public function __construct()
    {
        $dateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        parent::__construct();
        $this->date_inserted = $dateTime->format('Y-m-d H:i');
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function getStatus(): bool
    {
        return $this->status;
    }
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
    public function getDateInserted()
    {
        return $this->date_inserted;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function loadById(int $id): void
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $this->id = $result['id'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            $this->status = $result['status'];
            $this->role = $result['role'];
        } else {
            throw new \Exception("User with ID $id not found.");
        }
    }

    public function checkUserCredentials($email, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':email', $email, \PDO::PARAM_STR);
        $queryPrepared->execute();
        $user = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            $storedHash = trim($user['password']);
            if (password_verify($password, $storedHash)) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM esgi_user";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createUser($firstname, $lastname, $email, $password, $role)
    {
        try {
            $query = "INSERT INTO esgi_user (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)";
            $queryPrepared = $this->pdo->prepare($query);
            $queryPrepared->bindParam(':firstname', $firstname);
            $queryPrepared->bindParam(':lastname', $lastname);
            $queryPrepared->bindParam(':email', $email);
            $queryPrepared->bindParam(':password', $password);
            $queryPrepared->bindParam(':role', $role);
            return $queryPrepared->execute();
        } catch (\PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $firstname, $lastname, $email, $role)
    {
        $query = "UPDATE esgi_user SET firstname = :firstname, lastname = :lastname, email = :email, role = :role WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':id', $id);
        $queryPrepared->bindParam(':firstname', $firstname);
        $queryPrepared->bindParam(':lastname', $lastname);
        $queryPrepared->bindParam(':email', $email);
        $queryPrepared->bindParam(':role', $role);
        return $queryPrepared->execute();
    }

    public function delete()
    {
        $queryPrepared = $this->pdo->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        $queryPrepared->bindParam(':id', $this->id, \PDO::PARAM_INT);
        return $queryPrepared->execute();
    }
}
