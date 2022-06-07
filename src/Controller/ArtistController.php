<?php

namespace App\Controller;

use App\Form\ArtistsPageFormType;
use App\Model\ArtistsPageModel;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    private ArtistRepository $artistRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        ArtistRepository $artistRepository,
        GenreRepository $genreRepository
    ) {
        $this->artistRepository = $artistRepository;
        $this->genreRepository = $genreRepository;
    }

    #[Route('/artists', name: 'page-artists', methods: ['GET'])]
    public function actionArtists(Request $request): Response
    {
        $model = new ArtistsPageModel();
        $model->setLimit($request->get('limit') ?? ArtistsPageModel::DEFAULT_LIMIT);
        $model->setSearchWord($request->get('searchWord'));
        $artists = $this->artistRepository->findByArtistsModel($model);
        $genres = $this->genreRepository->findAll();
        return $this->render('artists.html.twig', [
            'artists' => $artists,
            'genres' => $genres,
            'model' => $model
        ]);
    }

    #[Route('/artist/{id}', name: 'page-artist')]
    public function actionArtist(int $id): Response
    {
        $artist = $this->artistRepository->findOneBy(['id' => $id]);
        if ($artist) {
            return $this->render('artist.html.twig', [
                'artist' => $artist
            ]);
        }

        throw $this->createNotFoundException('Artist not found');
    }
}