<?php

namespace App\Entity;

use App\Repository\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntityRepository::class)
 */
class Entity
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
     * @ORM\ManyToMany(targetEntity=EntityField::class)
     */
    private $fields;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_impuestos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_percepcion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_retencion;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="type")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=EntityTypeDoc::class, mappedBy="entity", orphanRemoval=true)
     */
    private $types;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    /**
     * @return Collection<int, EntityField>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(EntityField $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
        }

        return $this;
    }

    public function removeField(EntityField $field): self
    {
        $this->fields->removeElement($field);

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

    public function isHasPercepcion(): ?bool
    {
        return $this->has_percepcion;
    }

    public function setHasPercepcion(bool $has_percepcion): self
    {
        $this->has_percepcion = $has_percepcion;

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
            $document->setType($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getType() === $this) {
                $document->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EntityTypeDoc>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(EntityTypeDoc $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setEntity($this);
        }

        return $this;
    }

    public function removeType(EntityTypeDoc $type): self
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getEntity() === $this) {
                $type->setEntity(null);
            }
        }

        return $this;
    }

   
}
