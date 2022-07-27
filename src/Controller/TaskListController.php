<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskListController extends AbstractController
{
    #[Route("/board/task-list")]
    public function getTaskList(TaskListRepository $repository)
    {
        return $this->json([
           'taskList' => $repository->findAll()
        ]);
    }

    #[Route("/board/create-task-list")]
    public function createTaskList(TaskListRepository $repository, BoardRepository $boardRepository, int $id)
    {
        $taskList = new TaskList();
        $taskList->setBoard($boardRepository->find($id));

        $repository->add($taskList, true);

        return $this->json([]);
    }

    #[Route("/board/remove-task-list")]
    public function removeTaskList(TaskListRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->render('/board');
    }


}