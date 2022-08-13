<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskListController extends AbstractController
{
    #[Route("/task-lists", methods: 'POST')]
    public function createTaskList(
        TaskListRepository $repository,
        BoardRepository $boardRepository,
        int $id,
        Request $request
    )
    {
        $boardId = $request->get('boardId');

        $taskList = new TaskList();
        $taskList->setBoard($boardRepository->find($boardId));
        $taskList->setTitle('TaskList');

        $repository->add($taskList, true);

        return $this->json([]);
    }

    #[Route("/task-lists/{id}", methods: 'PUT')]
    public function editBoard(
        TaskListRepository $repository,
        int $id,
        Request $request
    ): Response
    {
        $taskList = $repository->find($id);
        $taskList->setTitle($request->get('task-list'));

        $repository->add($taskList, true);

        return $this->json([]);
    }

    #[Route("/task-lists/{id}", methods: 'DELETE')]
    public function removeTaskList(TaskListRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->redirect('/boards');
    }

}