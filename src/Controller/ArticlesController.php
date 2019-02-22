<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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
     * Permet d'afficher l'article
     *
     * @Route("/articles/{slug}", name="articles_show")
     * 
     * @return Response
     */
    public function show(Request $request, Articles $article, Commentaires $commentaire, ObjectManager $manager)
    {
        $commentaire = new Commentaires();

        $form = $this->createForm(CommentairesType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $commentaire->setCreatedAt(new \DateTime());

            $manager->persist($commentaire);

            $manager->flush();

        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
