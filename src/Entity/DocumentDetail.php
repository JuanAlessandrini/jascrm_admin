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

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $precio_unitario;

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
        $this->ammount = str_replace(',','',$ammount);

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

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(string $cantidad): self
    {
        $this->cantidad = str_replace(',','',$cantidad);

        return $this;
    }

    public function getPrecioUnitario(): ?string
    {
        return $this->precio_unitario;
    }

    public function setPrecioUnitario(string $precio_unitario): self
    {
        $this->precio_unitario = str_replace(',','',$precio_unitario);

        return $this;
    }
}
