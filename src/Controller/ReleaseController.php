<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReleaseController extends AbstractController
{
    #[Route('/releases', name: 'page-releases')]
    public function actionReleases(): Response
    {
        return $this->render('releases.html.twig');
    }

    #[Route('/release', name: 'page-release')]
    public function actionRelease(): Response
    {
        return $this->render('release.html.twig');
    }
}