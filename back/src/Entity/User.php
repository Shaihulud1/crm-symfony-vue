<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $apitoken;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tokenDeathDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InWork", mappedBy="user", orphanRemoval=true)
     */
    private $inWorks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    public function __construct()
    {
        $this->inWorks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getApitoken(): ?string
    {
        return $this->apitoken;
    }

    public function setApitoken(?string $apitoken): self
    {
        $this->apitoken = $apitoken;

        return $this;
    }

    public function getTokenDeathDate(): ?int
    {
        return $this->tokenDeathDate;
    }

    public function setTokenDeathDate(?int $tokenDeathDate): self
    {
        $this->tokenDeathDate = $tokenDeathDate;

        return $this;
    }

    /**
     * @return Collection|InWork[]
     */
    public function getInWorks(): Collection
    {
        return $this->inWorks;
    }

    public function addInWork(InWork $inWork): self
    {
        if (!$this->inWorks->contains($inWork)) {
            $this->inWorks[] = $inWork;
            $inWork->setUser($this);
        }

        return $this;
    }

    public function removeInWork(InWork $inWork): self
    {
        if ($this->inWorks->contains($inWork)) {
            $this->inWorks->removeElement($inWork);
            // set the owning side to null (unless already changed)
            if ($inWork->getUser() === $this) {
                $inWork->setUser(null);
            }
        }

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

}
