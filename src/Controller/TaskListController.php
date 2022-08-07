<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskListController extends AbstractController
{
    #[Route("/board/{id}/create-task-list")]
    public function createTaskList(TaskListRepository $repository, BoardRepository $boardRepository, int $id)
    {
        $taskList = new TaskList();
        $taskList->setBoard($boardRepository->find($id));
        $taskList->setTitle('TaskList');

        $repository->add($taskList, true);

        return $this->json([]);
    }

    #[Route("/task-list/{id}/edit")]
    public function editBoard(TaskListRepository $repository, int $id): Response
    {
        $taskList = $repository->find($id);
        $taskList->setTitle('TaskList-edit');

        $repository->add($taskList, true);

        return $this->json([]);
    }

    #[Route("task-list/{id}/remove")]
    public function removeTaskList(TaskListRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->redirect('/boards');
    }

}