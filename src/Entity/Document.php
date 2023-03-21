<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=DocumentField::class, mappedBy="document")
     */
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity=DocumentImpuesto::class, mappedBy="document",cascade={"persist"})
     */
    private $impuestos;

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
     * @ORM\Column(type="string", length=10, nullable=true)
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

    /**
     * @ORM\ManyToOne(targetEntity=Entidad::class, inversedBy="documents")
     */
    private $entidad;

    /**
     * @ORM\ManyToOne(targetEntity=EntidadTypeDoc::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sucursal;

    /**
     * @ORM\OneToMany(targetEntity=DocumentDetail::class, mappedBy="document",cascade={"persist"})
     */
    private $detail;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $emisor;

    /**
     * @ORM\ManyToOne(targetEntity=SubCuenta::class)
     */
    private $concepto_caja;

    /**
     * @ORM\ManyToOne(targetEntity=BankAccount::class, inversedBy="documents")
     */
    private $cuenta_bancaria;

   

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->impuestos = new ArrayCollection();
        $this->detail = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at = null): self
    {
        if (!$created_at){
            $this->created_at =  new \DateTime('now');
        }
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

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTime $modified_at): self
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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
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

    public function getEntidad(): ?Entidad
    {
        return $this->entidad;
    }

    public function setEntidad(?Entidad $entidad): self
    {
        $this->entidad = $entidad;

        return $this;
    }

    public function getTipo(): ?EntidadTypeDoc
    {
        return $this->tipo;
    }

    public function setTipo(?EntidadTypeDoc $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getSucursal(): ?string
    {
        return $this->sucursal;
    }

    public function setSucursal(?string $sucursal): self
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * @return Collection<int, DocumentDetail>
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(DocumentDetail $detail): self
    {
        if (!$this->detail->contains($detail)) {
            $this->detail[] = $detail;
            $detail->setDocument($this);
        }

        return $this;
    }

    public function removeDetail(DocumentDetail $detail): self
    {
        if ($this->detail->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getDocument() === $this) {
                $detail->setDocument(null);
            }
        }

        return $this;
    }

    public function getEmisor(): ?string
    {
        return $this->emisor;
    }

    public function setEmisor(?string $emisor): self
    {
        $this->emisor = $emisor;

        return $this;
    }

    public function getConceptoCaja(): ?SubCuenta
    {
        return $this->concepto_caja;
    }

    public function setConceptoCaja(?SubCuenta $concepto_caja): self
    {
        $this->concepto_caja = $concepto_caja;

        return $this;
    }

    public function getCuentaBancaria(): ?BankAccount
    {
        return $this->cuenta_bancaria;
    }

    public function setCuentaBancaria(?BankAccount $cuenta_bancaria): self
    {
        $this->cuenta_bancaria = $cuenta_bancaria;

        return $this;
    }

}
