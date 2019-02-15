<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('contact/contact.html.twig');
    }

    /**
     * @Route("/prendre-rendez-vous", name="rendez_vous")
     */
    public function newsletter()
    {
        return $this->render('contact/rendez-vous.html.twig');
    }
}
