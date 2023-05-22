<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends BaseEntity
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
     * @ORM\Column(type="string", length=255)
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="customer", orphanRemoval=true)
     */
    private $documents;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $campanias;

    /**
     * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="customer",cascade={"persist"})
     */
    private $bankAccounts;

    /**
     * @ORM\OneToMany(targetEntity=MovimientoContable::class, mappedBy="customer")
     */
    private $movimientoContables;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sucursales;

    /**
     * @ORM\OneToMany(targetEntity=CuentaBancaria::class, mappedBy="cliente", orphanRemoval=true)
     */
    private $cuentaBancarias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $centro_costos;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="clientes")
     */
    private $users;

    

    public function __construct()
    {
        $this->entities = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->bankAccounts = new ArrayCollection();
        $this->movimientoContables = new ArrayCollection();
        $this->cuentaBancarias = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function setCuit(string $cuit): self
    {
        $this->cuit = $cuit;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCustomer($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCustomer() === $this) {
                $document->setCustomer(null);
            }
        }

        return $this;
    }

    public function getCampanias(): ?string
    {
        return $this->campanias;
    }

    public function setCampanias(?string $campanias): self
    {
        $this->campanias = $campanias;

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(BankAccount $bankAccount): self
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts[] = $bankAccount;
            $bankAccount->setCustomer($this);
        }

        return $this;
    }

    public function removeBankAccount(BankAccount $bankAccount): self
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getCustomer() === $this) {
                $bankAccount->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoContable>
     */
    public function getMovimientoContables(): Collection
    {
        return $this->movimientoContables;
    }

    public function addMovimientoContable(MovimientoContable $movimientoContable): self
    {
        if (!$this->movimientoContables->contains($movimientoContable)) {
            $this->movimientoContables[] = $movimientoContable;
            $movimientoContable->setCustomer($this);
        }

        return $this;
    }

    public function removeMovimientoContable(MovimientoContable $movimientoContable): self
    {
        if ($this->movimientoContables->removeElement($movimientoContable)) {
            // set the owning side to null (unless already changed)
            if ($movimientoContable->getCustomer() === $this) {
                $movimientoContable->setCustomer(null);
            }
        }

        return $this;
    }

    public function getSucursales(): ?string
    {
        return $this->sucursales;
    }

    public function setSucursales(?string $sucursales): self
    {
        $this->sucursales = $sucursales;

        return $this;
    }

    /**
     * @return Collection<int, CuentaBancaria>
     */
    public function getCuentaBancarias(): Collection
    {
        return $this->cuentaBancarias;
    }

    public function addCuentaBancaria(CuentaBancaria $cuentaBancaria): self
    {
        if (!$this->cuentaBancarias->contains($cuentaBancaria)) {
            $this->cuentaBancarias[] = $cuentaBancaria;
            $cuentaBancaria->setCliente($this);
        }

        return $this;
    }

    public function removeCuentaBancaria(CuentaBancaria $cuentaBancaria): self
    {
        if ($this->cuentaBancarias->removeElement($cuentaBancaria)) {
            // set the owning side to null (unless already changed)
            if ($cuentaBancaria->getCliente() === $this) {
                $cuentaBancaria->setCliente(null);
            }
        }

        return $this;
    }

    public function getCentroCostos(): ?string
    {
        return $this->centro_costos;
    }

    public function setCentroCostos(?string $centro_costos): self
    {
        $this->centro_costos = $centro_costos;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCliente($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCliente($this);
        }

        return $this;
    }

    
}
