<?php

namespace App\Entity\Car;

use App\Entity\Driver;
use App\Entity\Freight\Freight;
use App\Repository\Car\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $horsePower = null;

    #[ORM\Column(length: 20)]
    private ?string $licensePlate = null;

    #[ORM\ManyToMany(targetEntity: Fuel::class, inversedBy: 'cars')]
    private Collection $fuelType;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $km = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?float $averageConsumption = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Freight::class)]
    private Collection $freights;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Tire::class)]
    private Collection $tires;

    #[ORM\OneToOne(inversedBy: 'currentCar', cascade: ['persist', 'remove'])]
    private ?Driver $currentDriver = null;

    public function __construct()
    {
        $this->fuelType = new ArrayCollection();
        $this->freights = new ArrayCollection();
        $this->tires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): self
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    /**
     * @return Collection<int, Fuel>
     */
    public function getFuelType(): Collection
    {
        return $this->fuelType;
    }

    public function addFuelType(Fuel $fuelType): self
    {
        if (!$this->fuelType->contains($fuelType)) {
            $this->fuelType->add($fuelType);
        }

        return $this;
    }

    public function removeFuelType(Fuel $fuelType): self
    {
        $this->fuelType->removeElement($fuelType);

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAverageConsumption(): ?float
    {
        return $this->averageConsumption;
    }

    public function setAverageConsumption(?float $averageConsumption): self
    {
        $this->averageConsumption = $averageConsumption;

        return $this;
    }

    /**
     * @return Collection<int, Freight>
     */
    public function getFreights(): Collection
    {
        return $this->freights;
    }

    public function addFreight(Freight $freight): self
    {
        if (!$this->freights->contains($freight)) {
            $this->freights->add($freight);
            $freight->setCar($this);
        }

        return $this;
    }

    public function removeFreight(Freight $freight): self
    {
        if ($this->freights->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getCar() === $this) {
                $freight->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tire>
     */
    public function getTires(): Collection
    {
        return $this->tires;
    }

    public function addTire(Tire $tire): self
    {
        if (!$this->tires->contains($tire)) {
            $this->tires->add($tire);
            $tire->setCar($this);
        }

        return $this;
    }

    public function removeTire(Tire $tire): self
    {
        if ($this->tires->removeElement($tire)) {
            // set the owning side to null (unless already changed)
            if ($tire->getCar() === $this) {
                $tire->setCar(null);
            }
        }

        return $this;
    }

    public function getCurrentDriver(): ?Driver
    {
        return $this->currentDriver;
    }

    public function setCurrentDriver(?Driver $currentDriver): self
    {
        $this->currentDriver = $currentDriver;

        return $this;
    }
}
