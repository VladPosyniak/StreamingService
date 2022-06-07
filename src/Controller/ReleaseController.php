<?php

namespace App\Controller;

use App\Form\ReleasePageFormType;
use App\Model\ReleasePageModel;
use App\Repository\GenreRepository;
use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReleaseController extends AbstractController
{
    private SongRepository $songRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        SongRepository $songRepository,
        GenreRepository $genreRepository
    ) {
        $this->songRepository = $songRepository;
        $this->genreRepository = $genreRepository;
    }

//    #[Route('/releases', name: 'page-releases', methods: ['GET', 'POST'])]
//    public function actionReleases(Request $request): Response {
//        $model = new ReleasePageModel();
//        $form = $this->createForm(ReleasePageFormType::class, $model);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $model = $form->getData();
//        }
//        $songs = $this->songRepository->findByReleaseModel($model);
//        $genres = $this->genreRepository->findAll();
//
//        return $this->render('releases.html.twig', [
//            'songs' => $songs,
//            'genres' => $genres,
//            'model' => $model
//        ]);
//    }

    #[Route('/release', name: 'page-release')]
    public function actionRelease(): Response
    {
        return $this->render('release.html.twig');
    }
}