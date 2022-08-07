<?php

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BoardController extends AbstractController
{
    #[Route("/boards")]
    public function getBoardsList(
        BoardRepository $repository,
        SerializerInterface $serializer
    )
    {
        $json = $serializer->serialize(
            ['boards' => $repository->findAll()],
            'json',
            ['groups' => ['boards']]
        );

        return new JsonResponse($json, json: true);
    }

    #[Route("/board/{id}")]
    public function getBoard(
        BoardRepository $repository,
        SerializerInterface $serializer,
        int $id
    )
    {
        $json = $serializer->serialize(
            $repository->find($id),
            'json',
            ['groups' => ['board']]
        );

        return new JsonResponse($json, json: true);
    }

    #[Route("/create-board")]
    public function createBoard(BoardRepository $repository)
    {
        $board = new Board();
        $board->setUser($this->getUser());
        $board->setTitle('board');

        $repository->add($board, true);

        return $this->json([],201);
    }

    #[Route("/board/{id}/edit")]
    public function editBoard(BoardRepository $repository, int $id): Response
    {
        $board = $repository->find($id);
        $board->setTitle('board-edit');

        $repository->add($board, true);

        return $this->json([]);
    }

    #[Route("/board/{id}/remove")]
    public function removeBoard(BoardRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->redirect('/boards');
    }

}
