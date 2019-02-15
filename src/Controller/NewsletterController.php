<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function newsletter()
    {
        return $this->render('newsletter/newsletter.html.twig');
    }

    /**
     * @Route("/actualités", name="actualites")
     */
    public function actualites()
    {
        return $this->render('newsletter/actualites.html.twig');
    }
}
