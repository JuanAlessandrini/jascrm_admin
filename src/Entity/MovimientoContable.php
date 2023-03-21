<?php

namespace App\Entity;

use App\Repository\MovimientoContableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoContableRepository::class)
 */
class MovimientoContable extends BaseEntity
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
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=CuentaAuxiliar::class)
     */
    private $cuenta_auxiliar;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="movimientoContables")
     */
    private $customer;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $monto;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class)
     */
    private $vendor;

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

    public function getCuenta(): ?Cuenta
    {
        return $this->cuenta;
    }

    public function setCuenta(?Cuenta $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getCuentaAuxiliar(): ?CuentaAuxiliar
    {
        return $this->cuenta_auxiliar;
    }

    public function setCuentaAuxiliar(?CuentaAuxiliar $cuenta_auxiliar): self
    {
        $this->cuenta_auxiliar = $cuenta_auxiliar;

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

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): self
    {
        $this->monto = $monto;

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
}
