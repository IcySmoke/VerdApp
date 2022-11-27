<?php

namespace App\Entity\Freight;

use App\Entity\Car\Car;
use App\Entity\Driver;
use App\Repository\Freight\FreightRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FreightRepository::class)]
class Freight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'freightsStarted')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $startLocation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\ManyToOne(inversedBy: 'freightsDestination')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $destination = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $destinationDate = null;

    #[ORM\ManyToOne(inversedBy: 'freights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Driver $driver = null;

    #[ORM\ManyToOne(inversedBy: 'freights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $distance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartLocation(): ?Location
    {
        return $this->startLocation;
    }

    public function setStartLocation(?Location $startLocation): self
    {
        $this->startLocation = $startLocation;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDestination(): ?Location
    {
        return $this->destination;
    }

    public function setDestination(?Location $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestinationDate(): ?\DateTimeInterface
    {
        return $this->destinationDate;
    }

    public function setDestinationDate(\DateTimeInterface $destinationDate): self
    {
        $this->destinationDate = $destinationDate;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
