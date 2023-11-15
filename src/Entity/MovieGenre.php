<?php

namespace App\Entity;

use App\Repository\MovieGenreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieGenreRepository::class)]
class MovieGenre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'idMovie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $idMovie = null;

    #[ORM\ManyToOne(inversedBy: 'idGenre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $idGenre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMovie(): ?Movie
    {
        return $this->idMovie;
    }

    public function setIdMovie(?Movie $idMovie): static
    {
        $this->idMovie = $idMovie;

        return $this;
    }

    public function getIdGenre(): ?Genre
    {
        return $this->idGenre;
    }

    public function setIdGenre(?Genre $idGenre): static
    {
        $this->idGenre = $idGenre;

        return $this;
    }
}
