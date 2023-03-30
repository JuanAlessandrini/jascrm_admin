<?php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private $cbu;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="bankAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sucursal;

    /**
     * @ORM\ManyToOne(targetEntity=Bank::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $banco;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="cuenta_bancaria")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=Cheque::class, mappedBy="movimiento_en_cuenta")
     */
    private $cheques;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->cheques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCbu(): ?string
    {
        return $this->cbu;
    }

    public function setCbu(string $cbu): self
    {
        $this->cbu = $cbu;

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

    public function getSucursal(): ?string
    {
        return $this->sucursal;
    }

    public function setSucursal(string $sucursal): self
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    public function getBanco(): ?Bank
    {
        return $this->banco;
    }

    public function setBanco(?Bank $banco): self
    {
        $this->banco = $banco;

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
            $document->setCuentaBancaria($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCuentaBancaria() === $this) {
                $document->setCuentaBancaria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cheque>
     */
    public function getCheques(): Collection
    {
        return $this->cheques;
    }

    public function addCheque(Cheque $cheque): self
    {
        if (!$this->cheques->contains($cheque)) {
            $this->cheques[] = $cheque;
            $cheque->setMovimientoEnCuenta($this);
        }

        return $this;
    }

    public function removeCheque(Cheque $cheque): self
    {
        if ($this->cheques->removeElement($cheque)) {
            // set the owning side to null (unless already changed)
            if ($cheque->getMovimientoEnCuenta() === $this) {
                $cheque->setMovimientoEnCuenta(null);
            }
        }

        return $this;
    }
}
