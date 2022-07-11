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
        ]);
    }

    public function show(int $id): string
    {
        $trainingManager = new TrainingManager();
        $training = $trainingManager->selectOneById($id);
        $inscription = $this->showUsersInTraining($id);
        return $this->twig->render('Training/show.html.twig', [
            'training' => $training,
            'inscription' => $inscription
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

    public function showUsersInTraining(int $id): ?string
    {
        $trainingUserManager = new TrainingUserManager();
        $students = $trainingUserManager->selectOneTrainingById($id);
        // Nombre d'élèves inscrits

        $studentsInTraining = count($students);
        // Nombre d'élèves maximum admissible pour le cours
        $maxStudents = 50;
        // Partie pour Twig : Training/show
        if ($studentsInTraining <= $maxStudents) {
            $inscription = 'open';
        } else {
            $inscription = 'close';
        }
        return $inscription;
    }
}
