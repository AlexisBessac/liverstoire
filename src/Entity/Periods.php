<?php

namespace App\Entity;

use App\Repository\PeriodsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PeriodsRepository::class)]
class Periods
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: "Veuillez entrer le nom de la période historique."
    )]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom de la période historique doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom de la période historique ne peut pas dépasser {{ limit }} caractères.",
        )]
    private ?string $name = null;

    #[ORM\Column(length: 7)]
    #[Assert\NotBlank(
        message: "Veuillez entrer la couleur associée à la période historique."
    )]
    #[Assert\Regex(
        pattern: '/^#[0-9A-Fa-f]{6}$/',
        message: 'La couleur doit être un code hexadécimal valide, par exemple #FFFFFF.'
    )]
    private ?string $color = null;

    /**
     * @var Collection<int, Events>
     */
    #[ORM\OneToMany(targetEntity: Events::class, mappedBy: 'periods')]
    private Collection $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setPeriods($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getPeriods() === $this) {
                $event->setPeriods(null);
            }
        }

        return $this;
    }
}
