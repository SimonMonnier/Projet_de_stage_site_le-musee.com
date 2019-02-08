<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VoitureRepository $repoVoiture)
    {
        $voitures = $repoVoiture->findAll();

        return $this->render('home/home.html.twig', [
            'voitures' => $voitures
        ]);
    }
}
