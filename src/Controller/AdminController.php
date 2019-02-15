<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\ImageRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface ;

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
            $manager->flush();
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
                $manager->flush();
            }

            $this->addFlash(
                'success',
                "La voiture <strong>{$voiture->getSlug()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('admin_voiture_show', [
                'slug' => $voiture->getSlug()
            ]);
        }
        return $this->render('admin/add_voiture.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * et d'effacer les Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/edit/voiture/{slug}", name="voiture_edit")
     * 
     * @return Response
     */
    public function edit_voiture(Voiture $voiture, Request $request, ObjectManager $manager)
    {
        $this->addFlash(
            'danger',
            "/!\ Toutes les photos actuelles de la voiture <strong>{$voiture->getSlug()}</strong> seront éffacées et remplacées /!\ "
        );

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $voiture->getCoverImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $voiture->setCoverImage($filename);
            $voiture->setCreateAt(new \DateTime());

            //ici on éfface toutes les anciennes images de la voiture 
            //dans la base de donnée et dans le dossier upload
            $images = $voiture->getImages();
            foreach ($images as $image)
            {
                //unlink sert à effacer le fichier dans uploads
                unlink( "uploads/".$image->getUrl() );
                $voiture->removeImage($image);
            }

            $manager->persist($voiture);
            $manager->flush();

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
                $manager->flush();
            }

            $this->addFlash(
                'success',
                "Les modifications de la voiture <strong>{$voiture->getSlug()}</strong> ont bien été enregistrées !"
            );

            return $this->redirectToRoute('admin_voiture_show', [
                'slug' => $voiture->getSlug()
            ]);
        }

        return $this->render('admin/edit_voiture.html.twig', [
            'form' => $form->createView(),
            'voiture' => $voiture
        ]);
    }

    /**
     * Permet d'afficher la voiture ajoutée
     *
     * @Route("/admin/voiture/{slug}", name="admin_voiture_show")
     * 
     * @return Response
     */
    public function show_voiture_added(Voiture $voiture)
    {   
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture
        ]);
    }
}
