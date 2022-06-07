<?php

namespace App\Controller;

use App\Service\RecommendationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecommendationController extends AbstractController
{
    private RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    #[Route('/recommendations', name: 'page-recommendations')]
    public function actionIndex(): Response
    {
        return $this->render('recommendations.html.twig', [
            'byGenreSongs' => $this->recommendationService->getListByGenre($this->getUser(), 10),
            'byOtherUserLikesSongs' => $this->recommendationService->getListByOtherUserLikes($this->getUser(), 10),
        ]);
    }
}