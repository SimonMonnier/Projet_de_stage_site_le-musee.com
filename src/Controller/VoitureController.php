<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\VoitureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    /**
     * Liste des voitures
     * @Route("/voitures", name="voitures_index")
     */
    public function index(VoitureRepository $repoVoiture)
    {
        $voitures = $repoVoiture->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures
        ]);
    }

    /**
     * Permet d'afficher le descriptif complet d'une voiture
     *
     * @Route("/voitures/{slug}", name="voitures_show")
     * 
     * @return Response
     */
    public function show($slug, VoitureRepository $repoVoiture)
    {   
        //on récupère ici la voiture correspondant au slug
        $voiture = $repoVoiture->findOneBySlug($slug);

        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture
        ]);
    }
}
