<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Service\RecommendationService;
use App\Service\SongService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private SongService $songService;
    private ArtistRepository $artistRepository;
    private RecommendationService $recommendationService;

    public function __construct(
        SongService $songService,
        ArtistRepository $artistRepository,
        RecommendationService $recommendationService
    ) {
        $this->songService = $songService;
        $this->artistRepository = $artistRepository;
        $this->recommendationService = $recommendationService;
    }

    #[Route('/', name: 'page-home')]
    public function actionHome(): Response
    {
        return $this->render('home.html.twig', [
            'newReleases' => $this->songService->getLastSingles(6),
            'artists' => $this->artistRepository->getNewArtists(6),
            'mostLiked' => $this->songService->getMostLiked(5),
            'newReleasesShort' => $this->songService->getLastSingles(5),
            'recommendations' => $this->getUser() !== null ?
                $this->recommendationService->getListByGenre($this->getUser(), 5) : []
        ]);
    }
}