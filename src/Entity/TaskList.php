<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\{Repository\TaskListRepository};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList
{
    #[Groups(['board'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(['boards', 'board'])]
    #[ORM\Column(length: 255)]
    private string $title;

    #[Groups(['board'])]
    #[ORM\OneToMany(mappedBy: "taskList", targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    #[ORM\ManyToOne(inversedBy: 'taskLists')]
    #[ORM\JoinColumn(nullable: false)]
    private Board $board;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function setBoard(Board $board): TaskList
    {
        $this->board = $board;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}