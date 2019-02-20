<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/actualités", name="articles")
     */
    public function index(ArticlesRepository $repoArticles)
    {
        $articles = $repoArticles->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Permet d'afficher le descriptif complet d'une voiture
     *
     * @Route("/articles/{slug}", name="articles_show")
     * 
     * @return Response
     */
    public function show(Articles $article)
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }
}
