<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        $this->denyAccessUnlessGranted('edit', $board);

        $taskList = new TaskList();

        $taskList->setBoard($board);
        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);
        $taskListId = $taskList->getId();

        return $this->json([
            'status' => 'ok',
            'data' => ['boardId' => $boardId, 'taskListId' => $taskListId]
        ]);
    }

    #[Route("/boards/{boardId}/task-lists", methods: 'GET')]
    public function create(
        BoardRepository $boardRepository,
        int             $boardId
    )
    {
        $board = $boardRepository->find($boardId);
        $boardId = $board->getId();

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok', 'data' => ['boardId' => $boardId]]);

//        return $this->render('todolist/task-list-edit.html.twig',
//            [
//                'taskListId' => 0,
//                'boardId' => $board->getId(),
//                'title' => ""
//            ]);
    }

    #[Route("/task-lists/{taskListId}", methods: 'PUT')]
    public function editTaskList(
        TaskListRepository $taskListRepository,
        int                $taskListId,
        Request            $request
    ): Response
    {
        $taskList = $taskListRepository->find($taskListId);
        $board = $taskList->getBoard();
        $boardId = $board->getId();

        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok','data' => ['boardId' => $boardId, 'taskListId' => $taskListId]]);
    }

    #[Route("/task-lists/{taskListId}", methods: 'DELETE')]
    public function removeTaskLists(
        TaskListRepository $taskListRepository,
        int                $taskListId,
    ): Response
    {
        $taskList = $taskListRepository->find($taskListId);

        if ($taskList === null) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted('edit', $taskList->getBoard());

        $taskListRepository->remove($taskList, true);

        return $this->json(['status' => 'ok']);
    }

}
