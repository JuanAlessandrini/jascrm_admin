<?php

namespace App\Entity;

use App\Repository\CuentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentaRepository::class)
 */
class Cuenta
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
     * @ORM\ManyToOne(targetEntity=AccountingGroup2::class, inversedBy="cuentas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grupo;

    /**
     * @ORM\OneToMany(targetEntity=SubCuenta::class, mappedBy="cuenta")
     */
    private $subCuentas;

    public function __construct()
    {
        $this->subCuentas = new ArrayCollection();
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

    public function getGrupo(): ?AccountingGroup2
    {
        return $this->grupo;
    }

    public function setGrupo(?AccountingGroup2 $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * @return Collection<int, SubCuenta>
     */
    public function getSubCuentas(): Collection
    {
        return $this->subCuentas;
    }

    public function addSubCuenta(SubCuenta $subCuenta): self
    {
        if (!$this->subCuentas->contains($subCuenta)) {
            $this->subCuentas[] = $subCuenta;
            $subCuenta->setCuenta($this);
        }

        return $this;
    }

    public function removeSubCuenta(SubCuenta $subCuenta): self
    {
        if ($this->subCuentas->removeElement($subCuenta)) {
            // set the owning side to null (unless already changed)
            if ($subCuenta->getCuenta() === $this) {
                $subCuenta->setCuenta(null);
            }
        }

        return $this;
    }
}
