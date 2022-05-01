<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    #[Route('/artists', name: 'page-artists')]
    public function actionArtists(): Response
    {
        return $this->render('artists.html.twig');
    }

    #[Route('/artist', name: 'page-artist')]
    public function actionArtist(): Response
    {
        return $this->render('artist.html.twig');
    }
}