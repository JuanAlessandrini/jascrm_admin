<?php

namespace App\Entity;

use App\Repository\EntidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntidadRepository::class)
 */
class Entidad
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
     * @ORM\Column(type="boolean")
     */
    private $has_impuestos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_perception;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_retencion;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="entidad")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=EntidadTypeDoc::class, mappedBy="entidad")
     */
    private $entidadTypeDocs;


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->entidadTypeDocs = new ArrayCollection();
        
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

    public function isHasImpuestos(): ?bool
    {
        return $this->has_impuestos;
    }

    public function setHasImpuestos(bool $has_impuestos): self
    {
        $this->has_impuestos = $has_impuestos;

        return $this;
    }

    public function isHasPerception(): ?bool
    {
        return $this->has_perception;
    }

    public function setHasPerception(bool $has_perception): self
    {
        $this->has_perception = $has_perception;

        return $this;
    }

    public function isHasRetencion(): ?bool
    {
        return $this->has_retencion;
    }

    public function setHasRetencion(bool $has_retencion): self
    {
        $this->has_retencion = $has_retencion;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setEntidad($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEntidad() === $this) {
                $document->setEntidad(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntidadTypeDoc>
     */
    public function getEntidadTypeDocs(): Collection
    {
        return $this->entidadTypeDocs;
    }

    public function addEntidadTypeDoc(EntidadTypeDoc $entidadTypeDoc): self
    {
        if (!$this->entidadTypeDocs->contains($entidadTypeDoc)) {
            $this->entidadTypeDocs[] = $entidadTypeDoc;
            $entidadTypeDoc->setEntidad($this);
        }

        return $this;
    }

    public function removeEntidadTypeDoc(EntidadTypeDoc $entidadTypeDoc): self
    {
        if ($this->entidadTypeDocs->removeElement($entidadTypeDoc)) {
            // set the owning side to null (unless already changed)
            if ($entidadTypeDoc->getEntidad() === $this) {
                $entidadTypeDoc->setEntidad(null);
            }
        }

        return $this;
    }
}
