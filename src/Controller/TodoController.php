<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{



//    #[Route("/boards")]
//    public function editList(BoardRepository $repository, Request $request): Response
//    {
////      $todoList->setTitle($request->get('title'));
//        $boards = $repository->findAll();
//
//        return $this->json($boards);
//    }
//
//    #[Route("/boards/task-lists")]
//    public function taskList(TaskListRepository $repository, Request $request): Response
//    {
//        $taskLists = $repository->findAll();
//
//        return $this->json($taskLists);
//    }

}
