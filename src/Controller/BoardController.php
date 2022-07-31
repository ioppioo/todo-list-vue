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
    #[Route("/board")]
    public function getBoard(BoardRepository $repository)
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

    #[Route("/board/{id}/edit")]
    public function editBoard(BoardRepository $repository, Request $request, int $id): Response
    {
        $board = $repository->find($id);
//      $board->setTitle($request->get('EditTitle'));
        $board->setTitle('EditTitle');

        $repository->add($board, true);

        return $this->json([]);
//      return new Response();
    }

    #[Route("/board/{id}/remove")]
    public function removeBoard(BoardRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->render('auth/signup.html.twig');
    }

    private function Response()
    {
    }
}
