<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskListController extends AbstractController
{
    #[Route("/task-lists", methods: 'POST')] // /boards/{id}/task-lists/create
    public function createTaskList(
        TaskListRepository $taskListRepository,
        BoardRepository $boardRepository,
        int $id,
        Request $request
    )
    {
//        if ($request->getMethod() === 'POST') {
//
//            $taskList = new TaskList();
//
//            $taskList->setBoard($request->get('id'));
//            $taskList->setTitle($request->get('title'));
//            $taskListRepository->add($taskList, true);
//
//            return $this->redirect('todolist/task-list.html.twig');
//        }
//
//        return $this->render('todolist/task-list.html.twig');


        $boardId = $request->get('boardId');

        $taskList = new TaskList();
        $taskList->setBoard($boardRepository->find($boardId));
        $taskList->setTitle('TaskList');

        $taskListRepository->add($taskList, true);

        return $this->json([]);

    }

    #[Route("/task-lists/{id}", methods: 'PUT')]
    public function editTaskList(
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