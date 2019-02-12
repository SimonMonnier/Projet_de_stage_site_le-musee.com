<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Voiture;
use App\Form\VoitureType;

class AdminController extends AbstractController
{
    /**
     * Permet à l'administrateur de se connecter
     * @Route("/admin/login", name="admin_login")
     */
    public function login()
    {
        return $this->render('admin/login.html.twig');
    }

    /**
     * Permet d'ajouter une voiture
     * @Route("/admin/new/voiture", name="voiture_add")
     * @return Response
     */
    public function add_voiture()
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);

        return $this->render('admin/add_voiture.html.twig');
    }
}
