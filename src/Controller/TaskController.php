<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskListRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route("/tasks", methods: 'POST')]
    public function store(
        TaskRepository     $taskRepository,
        TaskListRepository $taskListRepository,
        Request            $request
    )
    {
        $taskListId = $request->get('taskListId');
        $taskList = $taskListRepository->find($taskListId);

        $this->denyAccessUnlessGranted('edit', $taskList->getBoard());

//        $boardId = $taskList->getBoard()->getId();

        $task = new Task();

        $task->setTaskList($taskList);
        $task->setText($request->get('text'));
        $taskRepository->add($task, true);
        $id = $task->getId();

        return $this->json(['status' => 'ok','data' => ['id' => $id]]);
    }

    #[Route("/task-lists/{taskListId}/task", methods: 'GET')]
    public function createTask(
        TaskListRepository $taskListRepository,
        int                $taskListId,
    )
    {
        $taskList = $taskListRepository->find($taskListId);

        $this->denyAccessUnlessGranted('edit', $taskList->getBoard());

        return $this->json(['status' => 'ok', 'data' => ['taskListId' => $taskListId]]);
    }

    #[Route("/tasks/{id}", methods: 'PUT')]
    public function editTask(
        TaskRepository $taskRepository,
        int            $id,
        Request         $request
    ): Response
    {
        $task = $taskRepository->find($id);

        $task->setText($request->get('text'));
        $taskRepository->add($task, true);

        $this->denyAccessUnlessGranted('edit', $task->getTaskList()->getBoard());

        return $this->json(['status' => 'ok', 'data' => ['taskId' => $id]]);
    }

    #[Route("/tasks/{id}", methods: 'DELETE')]
    public function removeTask(
        TaskRepository $taskRepository,
        int            $id
    ): Response
    {
        $task = $taskRepository->find($id);

        if ($task === null) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted('edit', $task->getTaskList()->getBoard());

        $taskRepository->remove($task, true);

        return $this->json(['status' => 'ok']);
    }
}