<?php

namespace App\Model;

class TrainingUserManager extends AbstractManager
{
    public const TABLE = 'training_user';

    /**
     * Insert new Language in database
     */
    public function insert(array $trainingUser): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (training_id, user_id) 
        SELECT (':training_id', ':user_id') FROM training, user 
        WHERE NOT EXISTS (SELECT training_id, user_id FROM " . self::TABLE . "");
        $statement->bindValue(':training_id', $trainingUser['training_id'], \PDO::PARAM_INT);
        $statement->bindValue(':user_id', $trainingUser['user_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function delete(int $trainingId): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . "
        INNER JOIN training ON training.id = training_user.training_id 
        INNER JOIN user ON user.id = training_user.user_id 
        WHERE training_user.training_id = :training.id AND training_user.user_id = :user.id");
        $statement->bindValue(':training_id', $trainingId, \PDO::PARAM_INT);
        $statement->bindValue(':user_id', $trainingId, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Get one row from database by ID.
     * $id training_id
     * Return all users associated for the specified training by its id
     */
    public function selectOneTrainingById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT tu.user_id, tu.training_id, t.max_students 
        FROM " . static::TABLE . " AS tu 
            INNER JOIN training AS t ON t.id = tu.training_id
            INNER JOIN user AS u ON u.id = tu.user_id
            WHERE tu.training_id=:id
        ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Get one row from database by ID.
     * $id user_id
     * Return all training associated for the specified user by its id
     */
    public function selectOneUserById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT tu.user_id, tu.training_id FROM " . static::TABLE . " AS tu 
            INNER JOIN user AS u ON u.id = tu.user_id
            WHERE tu.user_id=:id
        ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
}
