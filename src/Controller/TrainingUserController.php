<?php

namespace App\Controller;

use App\Model\TrainingUserManager;

class TrainingUserController extends AbstractController
{
    /**
     * Add a new TrainingUser
     */
    public function add(array $trainingUserId): ?int
    {
        $trainingUser = new TrainingUserManager();
        return $trainingUser->Insert($trainingUserId);
    }

    public function delete($userId): void
    {
        $trainingUser = new TrainingUserManager();
        $trainingUser->delete((int)$userId);
    }
}
