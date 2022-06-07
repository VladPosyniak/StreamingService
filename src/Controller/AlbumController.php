<?php

namespace App\Controller;

use App\Entity\Album;
use App\Model\AlbumsPageModel;
use App\Repository\AlbumRepository;
use App\Repository\GenreRepository;
use App\Service\SongService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    private AlbumRepository $albumRepository;
    private GenreRepository $genreRepository;
    private SongService $songService;

    public function __construct(
        AlbumRepository $albumRepository,
        GenreRepository $genreRepository,
        SongService $songService
    ) {
        $this->albumRepository = $albumRepository;
        $this->genreRepository = $genreRepository;
        $this->songService = $songService;
    }

    #[Route('/album/{id}', name: "page-album", methods: 'GET',)]
    public function actionAlbum(int $id): Response
    {
        $album = $this->albumRepository->findOneBy(['id' => $id]);
        if ($album === null) {
            throw $this->createNotFoundException('Album not found');
        }

        return $this->render('album.html.twig', [
            'album' => $album,
            'otherAlbums' => $this->albumRepository->findBy([], [], 4)
        ]);
    }

    #[Route('/albums', name: "page-albums", methods: 'GET')]
    public function actionAlbums(Request $request): Response
    {
        $model = new AlbumsPageModel();
        $model->setLimit($request->get('limit') ?? AlbumsPageModel::DEFAULT_LIMIT);
        $model->setSearchWord($request->get('searchWord'));
        $albums = $this->albumRepository->findByAlbumsModel($model);
        $genres = $this->genreRepository->findAll();
        return $this->render('albums.html.twig', [
            'albums' => $albums,
            'model' => $model,
            'genres' => $genres,
            'lastSingles' => $this->songService->getLastSingles(),
            'mostLiked' => $this->songService->getMostLiked(),
        ]);
    }
}
