<?php

namespace App\Entity;

use App\Repository\CenturyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CenturyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Century
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"placeWithRelation"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"placeWithRelation"})
     */
    private $century;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"placeWithRelation"})
     */
    private $period;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, mappedBy="centuries")
     */
    private $places;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->places = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->century;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCentury(): ?string
    {
        return $this->century;
    }

    public function setCentury(string $century): self
    {
        $this->century = $century;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updated_at = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->addCentury($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            $place->removeCentury($this);
        }

        return $this;
    }
}
