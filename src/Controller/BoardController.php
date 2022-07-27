<?php

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    #[Route("/board")]
    public function getBoard(BoardRepository $repository): \Symfony\Component\HttpFoundation\JsonResponse
    {
        return $this->json([
            'board'=> $repository->findAll()
        ]);
    }

    #[Route("/board/create-board")]
    public function createBoard(BoardRepository $repository)
    {
        $board = new Board();
        $board->setTitle('test-title');

        $repository->add($board, true);

        return $this->json([],201);
    }

    #[Route("/board/edit/{id}")]
    public function editBoard(BoardRepository $repository, int $id)
    {
        $board = $repository->find($id);
        $board->setTitle('EditTitle');

        $repository->add($board, true);

        return $this->json([]);
    }

    #[Route("/board/remove/{id}")]
    public function removeBoard(BoardRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->render('auth/signup.html.twig');
    }
}
