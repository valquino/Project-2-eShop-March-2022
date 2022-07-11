<?php

namespace App\Controller;

use App\Model\TrainingManager;
use App\Model\TrainingUserManager;

class TrainingController extends AbstractController
{
    public function index(): string
    {
        $trainingManager = new TrainingManager();
        $trainings = $trainingManager->selectAll('title');
        return $this->twig->render('Training/index.html.twig', [
            'trainings' => $trainings,
            'loginErrors'   => $this->loginErrors,
        ]);
    }

    public function show(int $id): string
    {
        $trainingManager = new TrainingManager();
        $training = $trainingManager->selectOneById($id);
        return $this->twig->render('Training/show.html.twig', [
            'training' => $training,
            'loginErrors'   => $this->loginErrors,
        ]);
    }

    public function edit(int $id): ?string
    {
        $errors = [];
        $trainingManager = new TrainingManager();
        $training = $trainingManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trainingUpdated = array_map('trim', $_POST);
            $errors = $this->validateTrainings($trainingUpdated);
            if (empty($errors)) {
                $trainingManager->update($trainingUpdated);
                header('Location: /trainings/show?id=' . $id);
            }
        }
        return $this->twig->render('Training/edit.html.twig', [
            'training' => $training,
            'errors' => $errors,
            'loginErrors'   => $this->loginErrors,
        ]);
    }

    private function validateTrainings(array $training): array
    {
        $errors = [];
        $trainingManager = new TrainingManager();
        $existingTrainings = $trainingManager->selectAllTrainings();

        if ($this->fieldsAreFilled($training) === false) {
            $errors[] = 'All fields are required';
        }

        if (!empty($training['title']) && strlen($training['title']) > 255) {
            $errors[] = 'The title must not exceed 255 characters';
        }

        foreach ($existingTrainings as $existingTraining) {
            if (
                strcasecmp($training['title'], $existingTraining['title']) === 0
            ) {
                $errors[] = 'The cursu already exists';
            }
        }
        return $errors;
    }

    private function fieldsAreFilled(array $training): bool
    {
        if (
            !empty($training['title']) ||
            !empty($training['description']) ||
            !empty($training['price']) ||
            !empty($training['duration']) ||
            !empty($training['date_start']) ||
            !empty($training['date_end']) ||
            !empty($training['max_students'])
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function add(): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $training = array_map('trim', $_POST);
            $errors = $this->validateTrainings($training);
            if (empty($errors)) {
                $trainingManager = new TrainingManager();
                $id = $trainingManager->insert($training);
                header('Location:/trainings/show?id=' . $id);
                return null;
            }
        }
        return $this->twig->render('Training/add.html.twig', [
            'errors' => $errors,
            'loginErrors'   => $this->loginErrors,
        ]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $trainingManager = new TrainingManager();
            $trainingManager->delete((int) $id);

            header('Location:/trainings');
        }
    }
}
