<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface

{

    #[ORM\OneToMany(targetEntity: Clocking::class, mappedBy: 'clockingUser', orphanRemoval: true)]
    private Collection $clockings;
    #[ORM\Column(length: 255)]
    private ?string    $firstName = null;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int       $id        = null;
    #[ORM\Column(length: 255)]
    private ?string    $lastName  = null;
    #[ORM\Column(length: 255, unique: true)]
    private ?string    $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(length: 100)]
    private ?string $password = null;

    #[ORM\Column]
    private ?array $roles = [''];

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $active = null;


    public function __construct()
    {
        $this->clockings = new ArrayCollection();
    }

    public function addClocking(Clocking $clocking) : static
    {
        if(!$this->clockings->contains($clocking)) {
            $this->clockings->add($clocking);
            $clocking->setClockingUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Clocking>
     */
    public function getClockings() : Collection
    {
        return $this->clockings;
    }

    public function getFirstName() : ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) : static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getLastName() : ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName) : static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMatricule() : ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule) : void
    {
        $this->matricule = $matricule;
    }

    public function removeClocking(Clocking $clocking) : static
    {
        if($this->clockings->removeElement($clocking)) {
            // set the owning side to null (unless already changed)
            if($clocking->getClockingUser() === $this) {
                $clocking->setClockingUser(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

        /* * Get the value of roles
        */
        public function getRoles(): array
        {
            return $this->roles;
        }
    
        /**
         * Set the value of roles.
         *
         * @return self
         */
        public function setRoles(array $role)
        {
            $this->roles = $role;
    
            return $this;
        }

        public function getActive(): ?int
        {
            return $this->active;
        }

        public function setActive(?int $active): static
        {
            $this->active = $active;

            return $this;
        }
        //savoir si active pour l'authentification
        public function isActive(): ?bool
        {
            return $this->active;
        }

        public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials():void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
