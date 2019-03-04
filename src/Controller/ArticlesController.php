<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\ArticlesRepository;
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
        
        foreach ($articles as $article) 
        {
            $ids[] = $article->getId();
        }
        array_multisort($ids, SORT_DESC, $articles);

        return $this->render('articles/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * Permet d'afficher l'article
     *
     * @Route("/articles/{slug}", name="articles_show")
     * 
     * @return Response
     */
    public function show(Request $request, Articles $article, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        $commentaire = new Commentaires();

        $form = $this->createForm(CommentairesType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contenu = nl2br($request->get('commentaires')['contenu']);
            $commentaire->setCreatedAt(new \DateTime());
            $commentaire->setContenu($contenu);
            $commentaire-> setArticle($article);
            $manager->persist($commentaire);

            $manager->flush();

            $message = ( new \Swift_Message ( 'Nouveau commentaire' ))
                        -> setFrom ( 'info.lemusee@gmail.com' )
                        -> setTo ( 'contact@le-musee.fr' )
                        -> setBody ($this -> renderView ('home/email_commentaire.html.twig', [
                            'commentaire' => $commentaire                      
                            ]),'text/html'
                        );

            $mailer -> send ( $message );

        }

        return $this->render('articles/show.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }
}
