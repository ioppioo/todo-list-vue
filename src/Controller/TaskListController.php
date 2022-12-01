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
    ): Response
    {
        $boardId = $request->get('boardId');
        $board = $boardRepository->find($boardId);

        $taskList = new TaskList();

        $taskList->setBoard($board);
        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);
        $taskListId = $taskList->getId();

        return $this->json([
            'status' => 'ok',
            'data' => [
                'taskListId' => $taskListId,
                'boardId' => $boardId
            ]],
            200, [], ['groups' => ['taskLists']]);
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

        $taskList->setTitle($request->get('title'));
        $taskListRepository->add($taskList, true);

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok', 'data' => ['taskListId' => $taskListId]]);
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
