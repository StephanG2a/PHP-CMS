<?php

namespace App\Core;

abstract class Sql
{

    private static $instance;
    protected $pdo;
    protected $table;


    protected function __construct()
    {
        try {
            $this->pdo = new \PDO("pgsql:host=database;port=5432;dbname=esgi", "esgi", "Test1234");
            $this->pdo->exec("SET TIME ZONE 'Europe/Paris';");
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
        $classExploded = explode("\\", get_called_class());
        $this->table = end($classExploded);
        $this->table = "esgi_" . $this->table;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    // Check si l'email est déjà en base de donnée
    public function checkDuplicateEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':email', $email, \PDO::PARAM_STR);
        $queryPrepared->execute();
        return $queryPrepared->fetch(\PDO::FETCH_ASSOC);
    }

    // Création du token après enregistrement d'un utilisateur
    public function createToken(int $userId, string $token, \DateTime $expiresAt, string $type): bool
    {
        $formattedExpiresAt = $expiresAt->format('Y-m-d H:i:s');  // Store the formatted date in a variable

        $query = "INSERT INTO esgi_token (user_id, token, expires_at, type, created_at, updated_at) 
          VALUES (:user_id, :token, :expires_at, :type, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $queryPrepared->bindParam(':token', $token, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':expires_at', $formattedExpiresAt, \PDO::PARAM_STR);  // Bind the variable
        $queryPrepared->bindParam(':type', $type, \PDO::PARAM_STR);
        return $queryPrepared->execute();
    }

    // Vérification du token grace a un lien envoyé par email
    public function verifyTokenForUser(string $token, string $type): ?int
    {
        $query = "SELECT user_id FROM esgi_token WHERE token = :token AND type = :type AND expires_at > CURRENT_TIMESTAMP";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindParam(':token', $token, \PDO::PARAM_STR);
        $queryPrepared->bindParam(':type', $type, \PDO::PARAM_STR);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        return $result ? (int)$result['user_id'] : null;
    }

    public function save(): bool
    {
        $columns = get_object_vars($this);
        $columnsToDeleted = get_class_vars(get_class());
        $columns = array_diff_key($columns, $columnsToDeleted);
        unset($columns["id"]);

        if (is_numeric($this->getId()) && $this->getId() > 0) {
            $columnsUpdate = [];
            foreach ($columns as $key => $value) {
                $columnsUpdate[] = $key . "=:" . $key;
            }
            $queryPrepared = $this->pdo->prepare("UPDATE " . $this->table . " SET " . implode(",", $columnsUpdate) . " WHERE id=" . $this->getId());
        } else {
            $queryPrepared = $this->pdo->prepare("INSERT INTO " . $this->table . " (" . implode(",", array_keys($columns)) . ") 
                        VALUES (:" . implode(",:", array_keys($columns)) . ")");
        }

        // Bind parameters explicitly with their respective types
        foreach ($columns as $key => &$value) {
            if (is_bool($value)) {
                $queryPrepared->bindParam(':' . $key, $value, \PDO::PARAM_BOOL);
            } else {
                $queryPrepared->bindParam(':' . $key, $value, \PDO::PARAM_STR);
            }
        }

        // try {
        //     $queryPrepared->execute();
        //     if ($this->getId() === 0) {  // If this was an insert operation
        //         $lastId = $this->pdo->lastInsertId();
        //         $this->setId((int)$lastId);
        //     }
        // } catch (\PDOException $e) {
        //     die("Database error: " . $e->getMessage());
        // }
        try {
            $success = $queryPrepared->execute();
            if ($this->getId() === 0) {
                $lastId = $this->pdo->lastInsertId();
                $this->setId((int)$lastId);
            }
            return $success;
        } catch (\PDOException $e) {
            die("Database error: " . $e->getMessage());
            return false;  // Make sure to return false here
        }
    }
}
