<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\User;
use App\Repository\BoardRepository;
use App\Repository\TaskListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BoardController extends AbstractController
{
    #[Route("/boards", methods: 'POST')]
    public function store(
        BoardRepository $boardRepository,
        Request         $request
    )
    {
        $board = new Board();

        $board->setUser($this->getUser());
        $board->setTitle($request->get('title'));
        $boardRepository->add($board, true);
        $boardId = $board->getId();

        return $this->json([
            'status' => 'ok',
            'data' => ['boardId' => $boardId]]);
    }

    #[Route("/boards", methods: 'GET')]
    public function getBoardsList()
    {
        /** @var User $user */
        $user = $this->getUser();
        $boards = $user->getBoards();

        return $this->json([
            'status' => 'ok',
            'data' => [
                'boards' => $boards,
            ]],
            200, [], ['groups' => ['boards']]
        );

    }

    #[Route("/boards/{id<\d+>}", name: 'boards_getBoard', methods: 'GET')] //requirements: ["id" => "\d+"]
    public function getBoard(
        Board           $board,
        BoardRepository $boardRepository,
        Request         $request,
    )
    {
        $this->denyAccessUnlessGranted('view', $board);

        $id = $request->get('id');
        $board = $boardRepository->find($id);

        $taskLists = $board->getTaskLists();

        return $this->json([
            'status' => 'ok',
            'data' => [
                'board' => $board,
                'taskLists' => $taskLists,
            ]],
            200, [], ['groups' => ['boards']]
        );
    }

    #[Route("/boards/{id<\d+>}", name: 'boards_editBoard', methods: 'PUT')]
    public function editBoard(
        BoardRepository $boardRepository,
        int             $id,
        Request         $request
    ): Response
    {
        $board = $boardRepository->find($id);

        $board->setTitle($request->get('title'));
        $boardRepository->add($board, true);

        $this->denyAccessUnlessGranted('edit', $board);

        return $this->json([
            'status' => 'ok',
            'data' => [
                'id' => $id,
                'board' => $board,
            ]
        ]);
    }

    #[Route("/boards/{id<\d+>}", name: 'boards_removeBoard', methods: 'DELETE')]
    public function removeBoard(
        BoardRepository $boardRepository,
        int             $id
    ): Response
    {
        $board = $boardRepository->find($id);

        $this->denyAccessUnlessGranted('edit', $board);

        $boardRepository->remove($board, true);

        return $this->json(['status' => 'ok']);
    }
}