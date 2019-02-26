<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticlesRepository;
use App\Repository\VoitureRepository;
use App\Entity\Articles;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticlesRepository $articlesRepository, VoitureRepository $voitureRepository)
    {
       
        $allarticles = $articlesRepository->findAll();
        $allvoitures = $voitureRepository->findAll();
        dump($allarticles);
        dump($allvoitures);
        



        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
