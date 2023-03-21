<?php

namespace App\Entity;

use App\Repository\CuentaAuxiliarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentaAuxiliarRepository::class)
 */
class CuentaAuxiliar
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
     * @ORM\ManyToOne(targetEntity=SubCuenta::class, inversedBy="cuentasAuxiliares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcuenta;

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

    public function getSubcuenta(): ?SubCuenta
    {
        return $this->subcuenta;
    }

    public function setSubcuenta(?SubCuenta $subcuenta): self
    {
        $this->subcuenta = $subcuenta;

        return $this;
    }
}
