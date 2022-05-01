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
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: SongGenre::class)]
    private $songGenres;

    public function __construct()
    {
        $this->songGenres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SongGenre>
     */
    public function getSongGenres(): Collection
    {
        return $this->songGenres;
    }

    public function addSongGenre(SongGenre $songGenre): self
    {
        if (!$this->songGenres->contains($songGenre)) {
            $this->songGenres[] = $songGenre;
            $songGenre->setGenre($this);
        }

        return $this;
    }

    public function removeSongGenre(SongGenre $songGenre): self
    {
        if ($this->songGenres->removeElement($songGenre)) {
            // set the owning side to null (unless already changed)
            if ($songGenre->getGenre() === $this) {
                $songGenre->setGenre(null);
            }
        }

        return $this;
    }
}
