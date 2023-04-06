<?php

namespace App\Entity;

use App\Repository\EntidadFieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntidadFieldRepository::class)
 */
class EntidadField
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

   
    public function __construct()
    {
        $this->entidades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Entidad>
     */
    public function getEntidades(): Collection
    {
        return $this->entidades;
    }

    public function addEntidade(Entidad $entidade): self
    {
        if (!$this->entidades->contains($entidade)) {
            $this->entidades[] = $entidade;
            $entidade->addField($this);
        }

        return $this;
    }

    public function removeEntidade(Entidad $entidade): self
    {
        if ($this->entidades->removeElement($entidade)) {
            $entidade->removeField($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
