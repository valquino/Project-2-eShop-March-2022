<?php

namespace App\Model;

class TrainingManager extends AbstractManager
{
    public const TABLE = 'training';

    public function selectAllTrainings(string $orderBy = '', string $direction = 'ASC'): array
    {
        $statement = ("SELECT training.id, training.title, training.price, training.description, 
        training.duration, training.date_start, training.date_end,
         training.max_students FROM "  . self::TABLE . ' LEFT JOIN stack ON ' . self::TABLE . '.stack_id = stack.id');
        if ($orderBy) {
            $statement .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($statement)->fetchAll();
    }

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT training.id, training.title, training.price, training.description,
         training.duration, training.date_start, training.date_end, training.max_students, stack.name
        FROM " . self::TABLE . ' LEFT JOIN stack ON ' . self::TABLE . '.stack_id = stack.id
         
        WHERE ' . self::TABLE . '.id=:id');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $training): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`,`price`,`description`,`duration`,
        `date_start`,`date_end`,`max_students`) VALUES (:title, :price, :description, :duration,
        :date_start, :date_end, :max_students)");
        $statement->bindValue('title', $training['title'], \PDO::PARAM_STR);
        $statement->bindValue('price', $training['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $training['description'], \PDO::PARAM_STR);
        $statement->bindValue('duration', $training['duration'], \PDO::PARAM_INT);
        $statement->bindValue('date_start', $training['date_start'], \PDO::PARAM_STR);
        $statement->bindValue('date_end', $training['date_end'], \PDO::PARAM_STR);
        $statement->bindValue('max_students', $training['max_students'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $training): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title,`price` = :price,
        `description` = :description, `duration` = :duration, `date_start` = :date_start,
        `date_end` = :date_end, `max_students` = :max_students WHERE id=:id");
        $statement->bindValue('id', $training['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $training['title'], \PDO::PARAM_STR);
        $statement->bindValue('price', $training['price'], \PDO::PARAM_STR);
        $statement->bindValue('description', $training['description'], \PDO::PARAM_STR);
        $statement->bindValue('duration', $training['duration'], \PDO::PARAM_INT);
        $statement->bindValue('date_start', $training['date_start'], \PDO::PARAM_STR);
        $statement->bindValue('date_end', $training['date_end'], \PDO::PARAM_STR);
        $statement->bindValue('max_students', $training['max_students'], \PDO::PARAM_INT);
        return $statement->execute();
    }
}
