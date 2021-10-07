<?php

namespace App\Entity;

use App\Repository\PokupatelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokupatelRepository::class)
 */
class Pokupatel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Buyer::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Auto::class, mappedBy="pokupatel")
     */
    private $Autos;

    public function __construct()
    {
        $this->Autos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?Buyer
    {
        return $this->username;
    }

    public function setUsername(Buyer $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Auto[]
     */
    public function getAutos(): Collection
    {
        return $this->Autos;
    }

    public function addAuto(Auto $auto): self
    {
        if (!$this->Autos->contains($auto)) {
            $this->Autos[] = $auto;
            $auto->setPokupatel($this);
        }

        return $this;
    }

    public function removeAuto(Auto $auto): self
    {
        if ($this->Autos->removeElement($auto)) {
            // set the owning side to null (unless already changed)
            if ($auto->getPokupatel() === $this) {
                $auto->setPokupatel(null);
            }
        }

        return $this;
    }
}
