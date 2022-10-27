<?php

namespace App\Entity\Car;

use App\Repository\Car\TireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TireRepository::class)]
class Tire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column]
    private ?int $aspectRatio = null;

    #[ORM\Column]
    private ?int $rim = null;

    #[ORM\Column]
    private ?int $loadIndex = null;

    #[ORM\Column(length: 1)]
    private ?string $speedRating = null;

    #[ORM\Column(nullable: true)]
    private ?int $distance = null;

    #[ORM\Column(length: 13)]
    private ?string $groupId = null;

    #[ORM\Column]
    private ?int $dot = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getAspectRatio(): ?int
    {
        return $this->aspectRatio;
    }

    public function setAspectRatio(int $aspectRatio): self
    {
        $this->aspectRatio = $aspectRatio;

        return $this;
    }

    public function getRim(): ?int
    {
        return $this->rim;
    }

    public function setRim(int $rim): self
    {
        $this->rim = $rim;

        return $this;
    }

    public function getLoadIndex(): ?int
    {
        return $this->loadIndex;
    }

    public function setLoadIndex(int $loadIndex): self
    {
        $this->loadIndex = $loadIndex;

        return $this;
    }

    public function getSpeedRating(): ?string
    {
        return $this->speedRating;
    }

    public function setSpeedRating(string $speedRating): self
    {
        $this->speedRating = $speedRating;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function setGroupId(string $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getDot(): ?int
    {
        return $this->dot;
    }

    public function setDot(int $dot): self
    {
        $this->dot = $dot;

        return $this;
    }
}
