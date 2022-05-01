<?php

namespace App\Entity;

use App\Repository\SongGenreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongGenreRepository::class)]
class SongGenre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Song::class, inversedBy: 'songGenres')]
    #[ORM\JoinColumn(nullable: false)]
    private $song;

    #[ORM\ManyToOne(targetEntity: Genre::class, inversedBy: 'songGenres')]
    #[ORM\JoinColumn(nullable: false)]
    private $genre;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
