<?php

namespace App\Entity;

use App\Repository\DocumentImpuestoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentImpuestoRepository::class)
 */
class DocumentImpuesto
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
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="impuestos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?SubCuenta
    {
        return $this->type;
    }

    public function setType(?SubCuenta $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = str_replace(',','',$value);

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
