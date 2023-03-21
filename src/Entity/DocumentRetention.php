<?php

namespace App\Entity;

use App\Repository\DocumentRetentionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRetentionRepository::class)
 */
class DocumentRetention
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
    private $ammount;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="retenciones")
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
