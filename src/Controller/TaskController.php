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
    #[Route("/tasks", methods: 'POST')]
    public function store(
        TaskRepository     $taskRepository,
        TaskListRepository $taskListRepository,
        Request            $request
    )
    {
        $taskListId = $request->get('taskListId');
        $taskList = $taskListRepository->find($taskListId);
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

        return $this->render('todolist/task-edit.html.twig',
            [
                'taskId' => 0,
                'taskList' => $taskList,
                'taskText' => ""
            ]);
    }

    #[Route("/tasks/{id}/edit", methods: 'GET')]
    public function editTask(
        TaskRepository $repository,
        int            $id,
    ): Response
    {
        $task = $repository->find($id);

        return $this->render('todolist/task-edit.html.twig',
            [
                'taskId' => $task->getId(),
                'taskList' => $task->getTaskList(),
                'taskText' => $task->getText()
            ]);
    }

    #[Route("/tasks/{id}/remove")]
    public function removeTask(
        TaskRepository $taskRepository,
        int            $id
    ): Response
    {
        $task = $taskRepository->find($id);
        $boardId = $task->getTaskList()->getBoard()->getId();
        $taskRepository->remove($task, true);

        return $this->redirect("/boards/{$boardId}");
    }
}