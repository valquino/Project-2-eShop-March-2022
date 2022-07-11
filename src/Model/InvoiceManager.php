<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

/**
 * Abstract class handling default manager.
 */
class InvoiceManager extends AbstractManager
{
    protected PDO $pdo;

    public const TABLE = 'invoice';

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT i.id, i.created_at, i.user_id, i.total, u.firstname, u.lastname  
            FROM ' . static::TABLE . ' AS i
            INNER JOIN user AS u ON u.id = i.user_id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     */
    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT i.id, i.created_at, i.user_id, i.total, u.firstname, u.lastname  
            FROM " . static::TABLE . " AS i 
            INNER JOIN user AS u ON u.id = i.user_id
            WHERE i.id=:id
        ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Delete row form an ID
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Insert new invoices in database
     */
    public function insert(array $invoice): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (user_id, total) VALUES (:user_id, :total)");
        $statement->bindValue('user_id', $invoice['userid'], \PDO::PARAM_INT);
        $statement->bindValue('total', $invoice['total'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update invoice in database
     */
    public function update(array $invoice): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " 
            SET user_id = :user_id, total = :total WHERE id=:id
        ");
        $statement->bindValue('id', $invoice['id'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $invoice['userid'], \PDO::PARAM_INT);
        $statement->bindValue('total', $invoice['total'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
