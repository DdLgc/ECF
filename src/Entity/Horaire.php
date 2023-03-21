<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_debut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getHeureDebut(): ?string
    {
        return $this->heure_debut;
    }

    /**
     * @param string|null $heure_debut
     */
    public function setHeureDebut(?string $heureDebut): void
    {
        $this->heure_debut = $heureDebut;
    }
}
