<?php

namespace App\Entity;

use App\Repository\ClockingProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClockingProjectRepository::class)]
class ClockingProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Clocking::class, inversedBy: 'clockingProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clocking $clocking = null;

    #[ORM\ManyToOne(inversedBy: 'clockingProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\Column]
    private ?int $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClocking(): ?Clocking
    {
        return $this->clocking;
    }

    public function setClocking(?Clocking $clocking): self
    {
        $this->clocking = $clocking;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}