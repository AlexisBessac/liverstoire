<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(
        message: "Veuillez entrer la date de l'évènement historique"
    )]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "La date de l'évènement historique doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le date de l'évènement historique ne peut pas dépasser {{ limit }} caractères.",
    )]
    private ?string $chronos = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(
        message: "Veuillez entrer le nom de l'évènement historique.",
    )]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Le nom de l'évènement historique doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le nom de l'évènement historique ne peut pas dépasser {{ limit }} caractères.",
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
     #[Assert\NotBlank(
        message: "Veuillez entrer la description de l'évènement historique.",
    )]
    #[Assert\Length(
        min : 2,
        max: 1000, 
        minMessage: 'Le contenu doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le contenu ne peut pas dépasser 1000 caractères.')]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?periods $periods = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChronos(): ?string
    {
        return $this->chronos;
    }

    public function setChronos(string $chronos): static
    {
        $this->chronos = $chronos;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPeriods(): ?periods
    {
        return $this->periods;
    }

    public function setPeriods(?periods $periods): static
    {
        $this->periods = $periods;

        return $this;
    }
}
