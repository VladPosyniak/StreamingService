<?php

namespace App\Entity;

use App\Repository\SongLikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: SongLikeRepository::class)]
class SongLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Song::class, inversedBy: 'songLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $song;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'songLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $fromUser;

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

    public function getFromUser(): ?UserInterface
    {
        return $this->fromUser;
    }

    public function setFromUser(?UserInterface $fromUser): self
    {
        $this->fromUser = $fromUser;

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
     * @return mixed
     */
    public function getSongId()
    {
        return $this->songId;
    }

    /**
     * @param mixed $songId
     */
    public function setSongId($songId): void
    {
        $this->songId = $songId;
    }
}
