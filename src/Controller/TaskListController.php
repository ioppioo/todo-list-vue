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

        $taskListId = (int)$request->get('taskListId');
        if ($taskListId === 0) {
            $taskList = new TaskList();
        } else {
            $taskList = $taskListRepository->find($taskListId);
        }

        $taskList->setBoard($board);
        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);

        return $this->json(['status' => 'ok']);
//        return $this->redirect("/boards/{$boardId}");
    }

    #[Route("/boards/{boardId}", methods: 'GET')]
    public function create(
        BoardRepository $boardRepository,
        int             $boardId
    )
    {
        $board = $boardRepository->find($boardId);

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok']);

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
    ): Response
    {
        $taskList = $taskListRepository->find($taskListId);
        $board = $taskList->getBoard();

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok']);
//        return $this->render('todolist/task-list-edit.html.twig',
//            [
//                'boardId' => $board->getId(),
//                'taskListId' => $taskList->getId(),
//                'title' => $taskList->getTitle()
//            ]);
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
