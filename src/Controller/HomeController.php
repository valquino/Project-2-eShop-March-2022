<?php

namespace App\Controller;

use App\Model\TrainingManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $trainingManager = new TrainingManager();
        $trainings = $trainingManager->selectAll('title');

        return $this->twig->render('Home/index.html.twig', [
            'trainings' => $trainings,
        ]);
    }

    public function show(int $id): string
    {
        // For the logout result
        $logout = false;
        if (isset($_GET['logout'])) {
            $logout = true;
            return $this->twig->render('Home/index.html.twig', [
            'logout' => $logout,
            ]);
        }
        $trainingManager = new TrainingManager();
        $training = $trainingManager->selectOneById($id);
        return $this->twig->render('Training/show.html.twig', [
            'training' => $training,
        ]);
    }
}
