<?php

namespace App\Entity;

use App\Repository\ChequeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChequeRepository::class)
 */
class Cheque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Bank::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $banco;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $numero;


    /**
     * @ORM\Column(type="datetime")
     */
    private $vencimiento;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $sucursal;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $monto;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="cheques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLibrador(): ?Vendor
    {
        return $this->librador;
    }

    public function setLibrador(?Vendor $librador): self
    {
        $this->librador = $librador;

        return $this;
    }

    public function getVencimiento(): ?\DateTimeInterface
    {
        return $this->vencimiento;
    }

    public function setVencimiento(\DateTimeInterface $vencimiento): self
    {
        $this->vencimiento = $vencimiento;

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

    public function getMovimientoEnCuenta(): ?BankAccount
    {
        return $this->movimiento_en_cuenta;
    }

    public function setMovimientoEnCuenta(?BankAccount $movimiento_en_cuenta): self
    {
        $this->movimiento_en_cuenta = $movimiento_en_cuenta;

        return $this;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }
}
