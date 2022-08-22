<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskListRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route("/task-lists/{id}/task")]
    public function createTask (
        TaskRepository $repository,
        TaskListRepository $taskListRepository,
        int $id,
        Request $request
    )
    {
        $taskListId = $request->get('id');

        $task = new Task();
        $task->setText('task');
        $task->setTaskList($taskListRepository->find($taskListId));

        $repository->add($task, true);

        return $this->json([], 201);
    }

    #[Route("/tasks/{id}/edit")]
    public function editTask(
        TaskRepository $repository,
        int $id,
        Request $request
    ): Response
    {
        $task = $repository->find($id);
        $task->setText($request->get('task-edit'));
        $task->setIsDone(0);

        $repository->add($task, true);

        return $this->json([]);
    }

    #[Route("/tasks/{id}/remove")]
    public function removeTask(TaskRepository $taskRepository, int $id)
    {
        $taskRepository->remove($taskRepository->find($id), true);

        return $this->redirect('/boards');
    }
}