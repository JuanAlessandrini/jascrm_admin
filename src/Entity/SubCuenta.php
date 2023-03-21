<?php

namespace App\Entity;

use App\Repository\SubCuentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubCuentaRepository::class)
 */
class SubCuenta
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
     * @ORM\ManyToOne(targetEntity=Cuenta::class, inversedBy="subCuentas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cuenta;

    /**
     * @ORM\OneToMany(targetEntity=CuentaAuxiliar::class, mappedBy="subcuenta")
     */
    private $cuentasAuxiliares;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    public function __construct()
    {
        $this->cuentasAuxiliares = new ArrayCollection();
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

    public function getCuenta(): ?Cuenta
    {
        return $this->cuenta;
    }

    public function setCuenta(?Cuenta $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * @return Collection<int, CuentaAuxiliar>
     */
    public function getCuentasAuxiliares(): Collection
    {
        return $this->cuentasAuxiliares;
    }

    public function addCuentasAuxiliare(CuentaAuxiliar $cuentasAuxiliare): self
    {
        if (!$this->cuentasAuxiliares->contains($cuentasAuxiliare)) {
            $this->cuentasAuxiliares[] = $cuentasAuxiliare;
            $cuentasAuxiliare->setSubcuenta($this);
        }

        return $this;
    }

    public function removeCuentasAuxiliare(CuentaAuxiliar $cuentasAuxiliare): self
    {
        if ($this->cuentasAuxiliares->removeElement($cuentasAuxiliare)) {
            // set the owning side to null (unless already changed)
            if ($cuentasAuxiliare->getSubcuenta() === $this) {
                $cuentasAuxiliare->setSubcuenta(null);
            }
        }

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }
}
