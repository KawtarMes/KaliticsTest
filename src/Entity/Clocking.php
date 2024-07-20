<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClockingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClockingRepository::class)]
class Clocking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'clockings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $clockingUser = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(targetEntity: ClockingProject::class, mappedBy: 'clocking', cascade: ['persist'], orphanRemoval: true)]
    private Collection $clockingProjects;

    public function __construct()
    {
        $this->clockingProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClockingUser(): ?User
    {
        return $this->clockingUser;
    }

    public function setClockingUser(?User $clockingUser): self
    {
        $this->clockingUser = $clockingUser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|ClockingProject[]
     */
    public function getClockingProjects(): Collection
    {
        return $this->clockingProjects;
    }

    public function addClockingProject(ClockingProject $clockingProject): self
    {
        if (!$this->clockingProjects->contains($clockingProject)) {
            $this->clockingProjects[] = $clockingProject;
            $clockingProject->setClocking($this);
        }

        return $this;
    }

    public function removeClockingProject(ClockingProject $clockingProject): self
    {
        if ($this->clockingProjects->removeElement($clockingProject)) {
            // set the owning side to null (unless already changed)
            if ($clockingProject->getClocking() === $this) {
                $clockingProject->setClocking(null);
            }
        }

        return $this;
    }
}