<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route("task-list/{id}/create-task")]
    public function createTask (TaskRepository $repository, TaskListRepository $taskListRepository, int $id)
    {
        $task = new Task();
        $task->setText('task');
        $task->setTaskList($taskListRepository->find($id));

        $repository->add($task, true);

        return $this->json([], 201);
    }

    #[Route("/task/{id}/edit")]
    public function editTask(TaskRepository $repository, int $id)
    {
        $task = $repository->find($id);
        $task->setText('task-edit');
        $task->setIsDone(0);

        $repository->add($task, true);

        return $this->json([]);
    }

    #[Route("/task/{id}/remove")]
    public function removeTask(TaskRepository $taskRepository, int $id)
    {
        $taskRepository->remove($taskRepository->find($id), true);

        return $this->redirect('/boards');
    }
}