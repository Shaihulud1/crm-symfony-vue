<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InWorkRepository")
 */
class InWork
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $objID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workType;

    /**
     * @ORM\Column(type="integer")
     */
    private $timeWork;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="inWorks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjID(): ?int
    {
        return $this->objID;
    }

    public function setObjID(int $objID): self
    {
        $this->objID = $objID;

        return $this;
    }

    public function getWorkType(): ?string
    {
        return $this->workType;
    }

    public function setWorkType(string $workType): self
    {
        $this->workType = $workType;

        return $this;
    }

    public function getTimeWork(): ?int
    {
        return $this->timeWork;
    }

    public function setTimeWork(int $timeWork): self
    {
        $this->timeWork = $timeWork;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
