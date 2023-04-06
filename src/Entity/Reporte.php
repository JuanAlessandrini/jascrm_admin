<?php

namespace App\Entity;

use App\Repository\ReporteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReporteRepository::class)
 */
class Reporte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=SubCuenta::class)
     */
    private $conceptos;

    /**
     * @ORM\ManyToMany(targetEntity=EntidadTypeDoc::class)
     */
    private $tipos;

    /**
     * @ORM\ManyToMany(targetEntity=EntidadField::class)
     */
    private $campos;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $template;

    public function __construct()
    {
        $this->conceptos = new ArrayCollection();
        $this->tipos = new ArrayCollection();
        $this->campos = new ArrayCollection();
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
     * @return Collection<int, SubCuenta>
     */
    public function getConceptos(): Collection
    {
        return $this->conceptos;
    }

    public function addConcepto(SubCuenta $concepto): self
    {
        if (!$this->conceptos->contains($concepto)) {
            $this->conceptos[] = $concepto;
        }

        return $this;
    }

    public function removeConcepto(SubCuenta $concepto): self
    {
        $this->conceptos->removeElement($concepto);

        return $this;
    }

    /**
     * @return Collection<int, EntidadTypeDoc>
     */
    public function getTipos(): Collection
    {
        return $this->tipos;
    }

    public function addTipo(EntidadTypeDoc $tipo): self
    {
        if (!$this->tipos->contains($tipo)) {
            $this->tipos[] = $tipo;
        }

        return $this;
    }

    public function removeTipo(EntidadTypeDoc $tipo): self
    {
        $this->tipos->removeElement($tipo);

        return $this;
    }

    /**
     * @return Collection<int, EntidadField>
     */
    public function getCampos(): Collection
    {
        return $this->campos;
    }

    public function addCampo(EntidadField $campo): self
    {
        if (!$this->campos->contains($campo)) {
            $this->campos[] = $campo;
        }

        return $this;
    }

    public function removeCampo(EntidadField $campo): self
    {
        $this->campos->removeElement($campo);

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
