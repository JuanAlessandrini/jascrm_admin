<?php

namespace App\Entity;

use App\Repository\DocumentDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentDetailRepository::class)
 */
class DocumentDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SubCuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $concepto;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $ammount;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="detail")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcepto(): ?SubCuenta
    {
        return $this->concepto;
    }

    public function setConcepto(?SubCuenta $concepto): self
    {
        $this->concepto = $concepto;

        return $this;
    }

    public function getAmmount(): ?string
    {
        return $this->ammount;
    }

    public function setAmmount(string $ammount): self
    {
        $this->ammount = $ammount;

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
