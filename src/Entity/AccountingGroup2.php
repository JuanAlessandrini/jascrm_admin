<?php

namespace App\Entity;

use App\Repository\AccountingGroup2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountingGroup2Repository::class)
 */
class AccountingGroup2
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
     * @ORM\OneToMany(targetEntity=Cuenta::class, mappedBy="grupo")
     */
    private $cuentas;

    /**
     * @ORM\ManyToOne(targetEntity=AccountingGroup1::class, inversedBy="accountingGroup2s")
     */
    private $group1;

    public function __construct()
    {
        $this->cuentas = new ArrayCollection();
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

    /**
     * @return Collection<int, Cuenta>
     */
    public function getCuentas(): Collection
    {
        return $this->cuentas;
    }

    public function addCuenta(Cuenta $cuenta): self
    {
        if (!$this->cuentas->contains($cuenta)) {
            $this->cuentas[] = $cuenta;
            $cuenta->setGrupo($this);
        }

        return $this;
    }

    public function removeCuenta(Cuenta $cuenta): self
    {
        if ($this->cuentas->removeElement($cuenta)) {
            // set the owning side to null (unless already changed)
            if ($cuenta->getGrupo() === $this) {
                $cuenta->setGrupo(null);
            }
        }

        return $this;
    }

    public function getGroup1(): ?AccountingGroup1
    {
        return $this->group1;
    }

    public function setGroup1(?AccountingGroup1 $group1): self
    {
        $this->group1 = $group1;

        return $this;
    }
}
