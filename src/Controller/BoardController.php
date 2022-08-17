<?php

namespace App\Controller;

use App\Entity\Board;
use App\Repository\BoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BoardController extends AbstractController
{
    #[Route("/boards", methods: 'GET')]
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

//        return new JsonResponse($json, json: true);
        return $this->render('todolist/boards.html.twig');
    }

    #[Route("/boards/{id}", methods: 'GET')]
    public function getBoard(
        BoardRepository $repository,
        SerializerInterface $serializer,
        int $id
    )
    {
        $json = $serializer->serialize(
            $repository->find($id),
            'json',
            ['groups' => ['todolist']]
        );

        return new JsonResponse($json, json: true);
    }

    #[Route("/boards", methods: 'POST')]
    public function createBoard(BoardRepository $repository, Request $request): Response
    {
        $board = new Board();
        $board->setUser($this->getUser());
        $board->setTitle('board-title');

        $repository->add($board, true);

        return $this->json([],201);
//        return new Response();
    }

    #[Route("/boards/{id}", methods: 'PUT')]
    public function editBoard(
        BoardRepository $repository,
        int $id,
        Request $request
    ): Response
    {
        $board = $repository->find($id);
        $board->setTitle($request->get('title'));

        $repository->add($board, true);

        return $this->json([]);
    }

    #[Route("/boards/{id}", methods: 'DELETE')]
    public function removeBoard(BoardRepository $repository, int $id)
    {
        $repository->remove($repository->find($id), true);

        return $this->redirect('/boards');
    }

}
