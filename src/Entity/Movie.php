<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $vote = null;

    #[ORM\Column]
    private ?int $idMoviedb = null;

    #[ORM\OneToMany(mappedBy: 'idMovie', targetEntity: MovieGenre::class, orphanRemoval: true)]
    private Collection $idMovie;

    public function __construct()
    {
        $this->idMovie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): static
    {
        $this->poster = $poster;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(?string $vote): static
    {
        $this->vote = $vote;

        return $this;
    }

    public function getIdMoviedb(): ?int
    {
        return $this->idMoviedb;
    }

    public function setIdMoviedb(int $idMoviedb): static
    {
        $this->idMoviedb = $idMoviedb;

        return $this;
    }

    /**
     * @return Collection<int, MovieGenre>
     */
    public function getIdMovie(): Collection
    {
        return $this->idMovie;
    }

    public function addIdMovie(MovieGenre $idMovie): static
    {
        if (!$this->idMovie->contains($idMovie)) {
            $this->idMovie->add($idMovie);
            $idMovie->setIdMovie($this);
        }

        return $this;
    }

    public function removeIdMovie(MovieGenre $idMovie): static
    {
        if ($this->idMovie->removeElement($idMovie)) {
            // set the owning side to null (unless already changed)
            if ($idMovie->getIdMovie() === $this) {
                $idMovie->setIdMovie(null);
            }
        }

        return $this;
    }
}
