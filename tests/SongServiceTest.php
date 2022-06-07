<?php

namespace App\Tests;

use App\Entity\Song;
use App\Entity\User;
use App\Repository\SongLikeRepository;
use App\Repository\SongRepository;
use App\Service\SongService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class SongServiceTest extends TestCase
{
    public function testLikeSong(): void
    {
        $songRepository = $this->createMock(SongRepository::class);
        $user = new User();
        $user->setId(1);
        $song = new Song();
        $song->setId(1);
        $songRepository->method('find')->willReturn($song);
        $songRepository->expects($this->once())->method('find');
        $songLikeRepository = $this->createMock(SongLikeRepository::class);
        $songLikeRepository->method('findOneBy')->willReturn(null);
        $songLikeRepository->expects($this->once())->method('findOneBy');
        $em = $this->createMock(EntityManagerInterface::class);
        $songService = new SongService($songRepository, $songLikeRepository, $em);

        $likeSongDto = $songService->likeSong($user, $song->getId());
        $this->assertTrue($likeSongDto->isLiked());
    }
}
