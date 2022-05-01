<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'songs')]
    private $album;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $path;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'song', targetEntity: SongGenre::class)]
    private $songGenres;

    #[ORM\OneToMany(mappedBy: 'song', targetEntity: SongLike::class)]
    private $songLikes;


    public function __construct()
    {
        $this->songGenres = new ArrayCollection();
        $this->songLikes = new ArrayCollection();
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

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
            $songGenre->setSong($this);
        }

        return $this;
    }

    public function removeSongGenre(SongGenre $songGenre): self
    {
        if ($this->songGenres->removeElement($songGenre)) {
            // set the owning side to null (unless already changed)
            if ($songGenre->getSong() === $this) {
                $songGenre->setSong(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SongLike>
     */
    public function getSongLikes(): Collection
    {
        return $this->songLikes;
    }

    public function addSongLike(SongLike $songLike): self
    {
        if (!$this->songLikes->contains($songLike)) {
            $this->songLikes[] = $songLike;
            $songLike->setSong($this);
        }

        return $this;
    }

    public function removeSongLike(SongLike $songLike): self
    {
        if ($this->songLikes->removeElement($songLike)) {
            // set the owning side to null (unless already changed)
            if ($songLike->getSong() === $this) {
                $songLike->setSong(null);
            }
        }

        return $this;
    }

}
