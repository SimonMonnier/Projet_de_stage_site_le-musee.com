<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

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
    public function add_voiture(Request $request, ObjectManager $manager)
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $voiture->getCoverImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $voiture->setCoverImage($filename);
            $voiture->setCreateAt(new \DateTime());

            $manager->persist($voiture);
            $manager->flush($voiture);
            $files = $request->files->get('voiture')['files'];
            
            foreach ($files as $file)
            {
                $images = new Image();

                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $images->setUrl($filename);
                $images->setCaption($voiture->getSlug());
                $images->setVoiture($voiture);

                $manager->persist($images);
                $manager->flush($images);
            }

            return $this->redirectToRoute('admin_voiture_show', [
                'slug' => $voiture->getSlug()
            ]);
        }
        return $this->render('admin/add_voiture.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le descriptif complet d'une voiture
     *
     * @Route("/admin/voitures/{slug}", name="admin_voiture_show")
     * 
     * @return Response
     */
    public function show(Voiture $voiture)
    {   
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture
        ]);
    }
}
