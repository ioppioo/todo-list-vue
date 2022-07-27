<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\{Repository\TaskListRepository};
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

//    #[ORM\Column(length: 255)]
//    private ?int $task_id = null;

    #[ORM\OneToMany(mappedBy: "taskList", targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    #[ORM\ManyToOne(inversedBy: 'taskLists')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $board;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function getBoard(): Collection
    {
        return $this->board;
    }

    public function setBoard($board): TaskList
    {
        $this->board = $board;

        return $this;
    }
}
