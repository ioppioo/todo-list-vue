<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TaskList;
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
        TaskRepository $taskRepository,
        Request        $request
    )
    {
        $task = new Task();

        $task->setText($request->get('text'));
        $task->setIsDone($request->get('isDone'));
        $taskRepository->add($task, true);

        $taskId = $task->getId();

        return $this->json([
            'status' => 'ok',
            'data' => ['taskId' => $taskId]
        ]);
    }

    #[Route("/tasks/{id}", methods: 'PUT')]
    public function editTask(
        TaskRepository $taskRepository,
        Task           $task,
        Request        $request
    ): Response
    {
        if ($request->get('text')) {
            $task->setText($request->get('text'));
        }

        if ($request->get('isDone') !== null) {
            $task->setIsDone($request->get('isDone'));
        }

        $taskRepository->add($task, true);

        $this->denyAccessUnlessGranted('edit', $task->getTaskList()->getBoard());

        return $this->json([
            'status' => 'ok',
//            'data' => ['taskId' => $id]
        ]);
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