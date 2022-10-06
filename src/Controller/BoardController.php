<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\User;
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
            $this->denyAccessUnlessGranted('edit', $board);
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
    public function getBoardsList()
    {
        /** @var User $user */
        $user = $this->getUser();
        $boards = $user->getBoards();

        return $this->render('todolist/boards.html.twig',
            [
                'boards' => $boards
            ]
        );
    }

    #[Route("/boards/{id}", methods: "GET")]
    public function getBoard(Board $board)
    {
        $this->denyAccessUnlessGranted('view', $board);

        return $this->render(
            'todolist/board.html.twig', [
                'board' => $board
            ]
        );
    }

    #[Route("/boards/{boardId}/edit", methods: "PUT")]
    public function editBoard(
        BoardRepository $boardRepository,
        int             $boardId
    ): Response
    {
        $board = $boardRepository->find($boardId);

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json(['status' => 'ok']);
//        return $this->render('todolist/boards-edit.html.twig',
//            [
//                'boardId' => $board->getId(),
//                'boardTitle' => $board->getTitle()
//            ]);
    }

    #[Route("/boards/{boardId}", methods: 'DELETE')]
    public function removeBoard(
        BoardRepository $boardRepository,
        int             $boardId
    ): Response
    {
        $board = $boardRepository->find($boardId);

        $this->denyAccessUnlessGranted('edit', $board);

        $boardRepository->remove( $board, true);

        return $this->json(['status' => 'ok']);
    }
}