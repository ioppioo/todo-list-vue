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

        $boardId = $taskList->getBoard()->getId();

        $taskId = (int)$request->get('taskId');
        if ($taskId === 0) {
            $task = new Task();
        } else {
            $task = $taskRepository->find($taskId);
        }

        $task->setTaskList($taskList);
        $task->setText($request->get('text'));
        $taskRepository->add($task, true);

        return $this->redirect("/boards/{$boardId}");
    }

    #[Route("/task-lists/{taskListId}/task/create", methods: 'GET')]
    public function createTask(
        TaskListRepository $taskListRepository,
        int                $taskListId,
    )
    {
        $taskList = $taskListRepository->find($taskListId);

        $this->denyAccessUnlessGranted('edit', $taskList->getBoard());

        return $this->json(['status' => 'ok']);
//        return $this->render('todolist/task-edit.html.twig',
//            [
//                'taskId' => 0,
//                'taskList' => $taskList,
//                'taskText' => ""
//            ]);
    }

    #[Route("/tasks/{id}/edit", methods: 'PUT')]
    public function editTask(
        TaskRepository $repository,
        int            $id,
    ): Response
    {
        $task = $repository->find($id);

        $this->denyAccessUnlessGranted('edit', $task->getTaskList()->getBoard());

        return $this->json(['status' => 'ok']);
// $this->render('todolist/task-edit.html.twig',
//            [
//                'taskId' => $task->getId(),
//                'taskList' => $task->getTaskList(),
//                'taskText' => $task->getText()
//            ]);
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