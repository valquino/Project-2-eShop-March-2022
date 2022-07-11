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

        // For the logout result
        $logout = false;
        if (isset($_GET['logout'])) {
            $logout = true;
            return $this->twig->render('Home/index.html.twig', [
                'trainings'     => $trainings,
                'logoutMessage' => $logout,
            ]);
        } else {
            return $this->twig->render('Home/index.html.twig', [
                'trainings'     => $trainings,
                'loginErrors'   => $this->loginErrors,
            ]);
        }
    }

    public function show(int $id): string
    {
        $trainingManager = new TrainingManager();
        $training = $trainingManager->selectOneById($id);
        return $this->twig->render('Training/show.html.twig', [
            'training'      => $training,
            'loginErrors'   => $this->loginErrors,
        ]);
    }
}
