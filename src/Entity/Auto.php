<?php

namespace App\Entity;

use App\Repository\AutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AutoRepository::class)
 */
class Auto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firm;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxPassanger;

    /**
     * @ORM\ManyToOne(targetEntity=Pokupatel::class, inversedBy="Autos")
     */
    private $pokupatel;

    /**
     * @ORM\ManyToMany(targetEntity=Buyer::class, mappedBy="Autos")
     */
    private $buyers;

    public function __construct()
    {
        $this->buyers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getFirm(): ?string
    {
        return $this->firm;
    }

    public function setFirm(string $firm): self
    {
        $this->firm = $firm;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getMaxPassanger(): ?int
    {
        return $this->maxPassanger;
    }

    public function setMaxPassanger(int $maxPassanger): self
    {
        $this->maxPassanger = $maxPassanger;

        return $this;
    }

    public function getPokupatel(): ?Pokupatel
    {
        return $this->pokupatel;
    }

    public function setPokupatel(?Pokupatel $pokupatel): self
    {
        $this->pokupatel = $pokupatel;

        return $this;
    }

    /**
     * @return Collection|Buyer[]
     */
    public function getBuyers(): Collection
    {
        return $this->buyers;
    }

    public function addBuyer(Buyer $buyer): self
    {
        if (!$this->buyers->contains($buyer)) {
            $this->buyers[] = $buyer;
            $buyer->addAuto($this);
        }

        return $this;
    }

    public function removeBuyer(Buyer $buyer): self
    {
        if ($this->buyers->removeElement($buyer)) {
            $buyer->removeAuto($this);
        }

        return $this;
    }
}
