<?php

namespace App\Entity\Freight;

use App\Repository\Freight\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\OneToMany(mappedBy: 'startLocation', targetEntity: Freight::class)]
    private Collection $freightsStarted;

    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: Freight::class)]
    private Collection $freightsDestination;

    #[ORM\Column(length: 255)]
    private ?string $name;

    public function __construct()
    {
        $this->freightsStarted = new ArrayCollection();
        $this->freightsDestination = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, Freight>
     */
    public function getFreightsStarted(): Collection
    {
        return $this->freightsStarted;
    }

    public function addFreightStarted(Freight $freight): self
    {
        if (!$this->freightsStarted->contains($freight)) {
            $this->freightsStarted->add($freight);
            $freight->setStartLocation($this);
        }

        return $this;
    }

    public function removeFreightStarted(Freight $freight): self
    {
        if ($this->freightsStarted->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getStartLocation() === $this) {
                $freight->setStartLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Freight>
     */
    public function getFreightsDestination(): Collection
    {
        return $this->freightsDestination;
    }

    public function addFreightDestination(Freight $freight): self
    {
        if (!$this->freightsDestination->contains($freight)) {
            $this->freightsDestination->add($freight);
            $freight->setDestination($this);
        }

        return $this;
    }

    public function removeFreightDestination(Freight $freight): self
    {
        if ($this->freightsDestination->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getStartLocation() === $this) {
                $freight->setStartLocation(null);
            }
        }

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
