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
    public function store(
        TaskListRepository $taskListRepository,
        BoardRepository    $boardRepository,
        Request            $request
    )
    {
        $boardId = $request->get('boardId');
        $board = $boardRepository->find($boardId);

        $taskList = new TaskList();

        $taskList->setBoard($board);
        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);

        return $this->redirect("/boards/{$boardId}");
    }

    #[Route("/boards/{boardId}/task-lists/create", methods: 'GET')]
    public function create(
        BoardRepository $boardRepository,
        int             $boardId
    )
    {
        $board = $boardRepository->find($boardId);

        return $this->render('todolist/task-list-edit.html.twig', ['boardId' => $board->getId()]);
    }

    #[Route("/task-lists/{id}/edit", methods: 'PUT')]
    public function editTaskList(
        TaskListRepository $repository,
        int                $id,
        Request            $request
    ): Response
    {
        $taskList = $repository->find($id);
        $taskList->setTitle($request->get('task-list'));

        $repository->add($taskList, true);

        return $this->redirect('/boards');
    }

}