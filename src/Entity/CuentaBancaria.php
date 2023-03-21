<?php

namespace App\Entity;

use App\Repository\CuentaBancariaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentaBancariaRepository::class)
 */
class CuentaBancaria
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
    private $banco;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private $cbu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sucursal;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="cuentaBancarias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanco(): ?string
    {
        return $this->banco;
    }

    public function setBanco(string $banco): self
    {
        $this->banco = $banco;

        return $this;
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

    public function getSucursal(): ?string
    {
        return $this->sucursal;
    }

    public function setSucursal(string $sucursal): self
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    public function getCliente(): ?Customer
    {
        return $this->cliente;
    }

    public function setCliente(?Customer $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }
}
