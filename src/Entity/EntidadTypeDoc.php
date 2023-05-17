<?php

namespace App\Entity;

use App\Repository\EntidadTypeDocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntidadTypeDocRepository::class)
 */
class EntidadTypeDoc
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
     * @ORM\Column(type="string", length=30)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $signo;

    /**
     * @ORM\ManyToOne(targetEntity=Entidad::class, inversedBy="entidadTypeDocs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entidad;

    /**
     * @ORM\ManyToMany(targetEntity=EntidadField::class)
     */
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="tipo")
     */
    private $documents;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->documents = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getSigno(): ?int
    {
        return $this->signo;
    }

    public function setSigno(int $signo): self
    {
        $this->signo = $signo;

        return $this;
    }

    public function getEntidad(): ?Entidad
    {
        return $this->entidad;
    }

    public function setEntidad(?Entidad $entidad): self
    {
        $this->entidad = $entidad;

        return $this;
    }

    /**
     * @return Collection<int, EntidadField>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(EntidadField $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
        }

        return $this;
    }

    public function removeField(EntidadField $field): self
    {
        $this->fields->removeElement($field);

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
            $document->setTipo($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getTipo() === $this) {
                $document->setTipo(null);
            }
        }

        return $this;
    }
}
