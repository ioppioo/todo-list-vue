<?php

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    #[Route("/boards", methods: "GET")]
    public function getBoardsList()
    {
        return $this->render('todolist/boards-edit.html.twig');
    }

    #[Route("/boards/{id}", methods: "GET")]
    public function getBoard(Board $board)
    {
        return $this->render(
            'todolist/board.html.twig', [
                'board' => $board
            ]
        );
    }

    #[Route("/boards", methods: "POST")]
    public function createBoard(BoardRepository $repository, Request $request)
    {
        $board = new Board();
        $board->setUser($this->getUser());
        $board->setTitle('board-title');

        $repository->add($board, true);

        return $this->json([], 201);
    }

    #[Route("/boards/{id}", methods: "PUT")]
    public function editBoard(
        BoardRepository $repository,
        int             $id,
        Request         $request
    ): Response
    {
        $board = $repository->find($id);
        $board->setTitle($request->get('title'));

        $repository->add($board, true);

        return $this->json([]);
    }

    #[Route("/boards/{id}", methods: "DELETE")]
    public function removeBoard(
        BoardRepository $repository,
        int             $id
    ): Response
    {
        $repository->remove($repository->find($id), true);

        return $this->redirect('/boards');
    }

}