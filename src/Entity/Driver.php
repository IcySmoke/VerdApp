<?php

namespace App\Entity;

use App\Entity\Car\Car;
use App\Entity\Freight\Freight;
use App\Repository\DriverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\Column(nullable: true)]
    private ?int $distanceDriven = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $employeeSince = null;

    #[ORM\OneToOne(inversedBy: 'driver', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'driver', targetEntity: Freight::class)]
    private Collection $freights;

    #[ORM\OneToOne(mappedBy: 'currentDriver', cascade: ['persist', 'remove'])]
    private ?Car $currentCar = null;

    public function __construct()
    {
        $this->freights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeImmutable $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getDistanceDriven(): ?int
    {
        return $this->distanceDriven;
    }

    public function setDistanceDriven(?int $distanceDriven): self
    {
        $this->distanceDriven = $distanceDriven;

        return $this;
    }

    public function getEmployeeSince(): ?\DateTimeImmutable
    {
        return $this->employeeSince;
    }

    public function setEmployeeSince(\DateTimeImmutable $employeeSince): self
    {
        $this->employeeSince = $employeeSince;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $freight->setDriver($this);
        }

        return $this;
    }

    public function removeFreight(Freight $freight): self
    {
        if ($this->freights->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getDriver() === $this) {
                $freight->setDriver(null);
            }
        }

        return $this;
    }

    public function getCurrentCar(): ?Car
    {
        return $this->currentCar;
    }

    public function setCurrentCar(?Car $currentCar): self
    {
        // unset the owning side of the relation if necessary
        if ($currentCar === null && $this->currentCar !== null) {
            $this->currentCar->setCurrentDriver(null);
        }

        // set the owning side of the relation if necessary
        if ($currentCar !== null && $currentCar->getCurrentDriver() !== $this) {
            $currentCar->setCurrentDriver($this);
        }

        $this->currentCar = $currentCar;

        return $this;
    }
}
