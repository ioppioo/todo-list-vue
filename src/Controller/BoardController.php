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
    #[Route("/boards", methods: 'POST')]
    public function store(
        BoardRepository $boardRepository,
        Request         $request
    )
    {
        $boardId = (int)$request->get('boardId');
        if ($boardId === 0) {
            $board = new Board();
        } else {
            $board = $boardRepository->find($boardId);
        }

        $board->setUser($this->getUser());
        $board->setTitle($request->get('title'));
        $boardRepository->add($board, true);

        return $this->redirect("/boards");
    }

    #[Route("/boards/create", methods: 'GET')]
    public function create()
    {
        return $this->render('todolist/boards-edit.html.twig',
            [
                'boardId' => 0,
                'boardTitle' => ""
            ]
        );
    }

    #[Route("/boards", methods: "GET")]
    public function getBoardsList(
        BoardRepository $boardRepository,
        Request         $request
    )
    {
        return $this->render('todolist/boards.html.twig',
            [
                'boards' => $boardRepository->findAll()
            ]
        );
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

    #[Route("/boards/{boardId}/edit", methods: "GET")]
    public function editBoard(
        BoardRepository $boardRepository,
        int             $boardId
    ): Response
    {
        $board = $boardRepository->find($boardId);

        return $this->render('todolist/boards-edit.html.twig',
            [
                'boardId' => $board->getId(),
                'boardTitle' => $board->getTitle()
            ]);
    }

    #[Route("/boards/{boardId}/remove")]
    public function removeBoard(
        BoardRepository $boardRepository,
        int             $boardId
    ): Response
    {
        $boardRepository->remove($boardRepository->find($boardId), true);

        return $this->redirect('/boards');
    }
}