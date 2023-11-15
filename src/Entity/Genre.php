<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idGenreMoviedb = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'idGenre', targetEntity: MovieGenre::class, orphanRemoval: true)]
    private Collection $idGenre;

    public function __construct()
    {
        $this->idGenre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGenreMoviedb(): ?int
    {
        return $this->idGenreMoviedb;
    }

    public function setIdGenreMoviedb(int $idGenreMoviedb): static
    {
        $this->idGenreMoviedb = $idGenreMoviedb;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

}
