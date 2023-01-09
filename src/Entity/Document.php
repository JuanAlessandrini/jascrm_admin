<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modified_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $modified_by;

    /**
     * @ORM\ManyToOne(targetEntity=Entity::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=DocumentField::class, mappedBy="document")
     */
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity=DocumentImpuesto::class, mappedBy="document")
     */
    private $impuestos;

    /**
     * @ORM\ManyToOne(targetEntity=EntityTypeDoc::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_doc;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $campania;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $total;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->impuestos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modified_by;
    }

    public function setModifiedBy(?User $modified_by): self
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getType(): ?Entity
    {
        return $this->type;
    }

    public function setType(?Entity $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, DocumentField>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(DocumentField $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
        }

        return $this;
    }

    public function removeField(DocumentField $field): self
    {
        $this->fields->removeElement($field);

        return $this;
    }

    /**
     * @return Collection<int, DocumentImpuesto>
     */
    public function getImpuestos(): Collection
    {
        return $this->impuestos;
    }

    public function addImpuesto(DocumentImpuesto $impuesto): self
    {
        if (!$this->impuestos->contains($impuesto)) {
            $this->impuestos[] = $impuesto;
            $impuesto->setDocument($this);
        }

        return $this;
    }

    public function removeImpuesto(DocumentImpuesto $impuesto): self
    {
        if ($this->impuestos->removeElement($impuesto)) {
            // set the owning side to null (unless already changed)
            if ($impuesto->getDocument() === $this) {
                $impuesto->setDocument(null);
            }
        }

        return $this;
    }

    public function getTypeDoc(): ?EntityTypeDoc
    {
        return $this->type_doc;
    }

    public function setTypeDoc(?EntityTypeDoc $type_doc): self
    {
        $this->type_doc = $type_doc;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getCampania(): ?string
    {
        return $this->campania;
    }

    public function setCampania(?string $campania): self
    {
        $this->campania = $campania;

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(?int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }
}
