<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route("/board/task-list/task")]
    public function getTask (TaskRepository $repository)
    {
        return $this->json([
            'task' => $repository->findAll()
        ]);
    }

    #[Route("/board/task-list/create-task")]
    public function createTask (TaskRepository $repository)
    {
        $task = new Task();
        $task->setText('задача 1');
        $task->setIsDone(true);

        $repository->add($task, true);

        return $this->json([], 201);
    }

    #[Route("/board/task-list/task-edit-{id}")]
    public function editTask(TaskRepository $repository, int $id)
    {
        $task = $repository->find($id);
        $task->setText('EditText');
        $task->setIsDone(0);

        $repository->add($task, true);

        return $this->json([]);
    }

    #[Route("/board/task-list/task-{id}")]
    public function removeTask(TaskRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->render('/board/task-list/remove-task');
    }
}