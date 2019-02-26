<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Repository\VoitureRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticlesRepository $articlesRepository, VoitureRepository $voitureRepository)
    {
        $allarticles = $articlesRepository->findall();
        



        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
