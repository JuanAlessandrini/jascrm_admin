<?php

namespace App\Entity;

use App\Repository\AccountingGroup1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountingGroup1Repository::class)
 */
class AccountingGroup1
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
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=AccountingGroup2::class, mappedBy="group1")
     */
    private $accountingGroup2s;

    public function __construct()
    {
        $this->accountingGroup2s = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, AccountingGroup2>
     */
    public function getAccountingGroup2s(): Collection
    {
        return $this->accountingGroup2s;
    }

    public function addAccountingGroup2(AccountingGroup2 $accountingGroup2): self
    {
        if (!$this->accountingGroup2s->contains($accountingGroup2)) {
            $this->accountingGroup2s[] = $accountingGroup2;
            $accountingGroup2->setGroup1($this);
        }

        return $this;
    }

    public function removeAccountingGroup2(AccountingGroup2 $accountingGroup2): self
    {
        if ($this->accountingGroup2s->removeElement($accountingGroup2)) {
            // set the owning side to null (unless already changed)
            if ($accountingGroup2->getGroup1() === $this) {
                $accountingGroup2->setGroup1(null);
            }
        }

        return $this;
    }
}
