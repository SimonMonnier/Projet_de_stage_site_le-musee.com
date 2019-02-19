<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\VoitureRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\is_granted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface ;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * Création de l'encodeur de mot de passe
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Permet à l'administrateur de se connecter
     * @Route("/admin/login", name="admin_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('admin/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de créer un nouvel administrateur
     * @Route("/admin/register", name="admin_register")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager)
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $user = new User();
            $adminRole = new Role();

            $form = $this->createForm(RegistrationType::class, $user);
            $form->handleRequest($request);

            $adminRole->setTitle('ROLE_ADMIN');
            $manager->persist($adminRole);
            
            $hash = $this->encoder->encodePassword($user, $request->files->get('user')['hash']);

            $user->addUserRole($adminRole)
                ->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'administrateur {$user->getUsername()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('admin_admins_index', [
                'slug' => $voiture->getSlug()
            ]);
        }

        return $this->render('admin/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * afffiche la totalité des administrateurs
     *@Route("/admin/admins", name="admin_admins_index")
     *@Security("is_granted('ROLE_ADMIN')")
     * @param UserRepository $repoUser
     * @return Response
     */
    public function index_admins(UserRepository $repoUser)
    {
        
        return $this->render('admin/index_admins.html.twig', [
            'users' => $repoUser->findAll()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * et d'effacer les Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/admin_account/edit/{email}", name="admin_account_edit")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function edit_admin(User $user, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $adminRole->setTitle('ROLE_ADMIN');
            $manager->persist($adminRole);
            
            $hash = $this->encoder->encodePassword($user, $request->files->get('user')['hash']);

            $user->addUserRole($adminRole)
                ->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'administrateur {$user->getUsername()} a bien été modifié !"
            );

            return $this->redirectToRoute('admin_admins_index');
        }

        return $this->render('admin/admin_account_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * Permet d'éffacer un administrateur
     *
     * @Route("/admin/admin_account/delete/{id}", name="admin_account_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function delete_user(User $user, ObjectManager $manager, UserRepository $repoUser)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'administrateur' a bien été supprimée !"
        );

        return $this->render('admin/voiture/index.html.twig', [
            'users' => $repouser->findAll()
        ]);
    }

    /**
     * Permet à l'administrateur de se déconnecter
     * @Route("/admin/logout", name="admin_logout")
     *
     */
    public function logout()
    {
        // Symfony gère la déconnexion tous seul
    }

    /**
     * afffiche la totalité des voitures
     *@Route("/admin/voitures", name="admin_voitures_index")
     *@Security("is_granted('ROLE_ADMIN')")
     * @param VoitureRepository $repoVoiture
     * @return Response
     */
    public function index(VoitureRepository $repoVoiture)
    {
        $this->addFlash(
            'danger',
            "/!\Lorsque vous modifiez une voiture, vous avez l'obligation de re-télécharger ses photos.Pensez à conserver les photos (Ex: clé usb, disque dur)/!\ "
        );
        return $this->render('admin/voiture/index.html.twig', [
            'voitures' => $repoVoiture->findAll()
        ]);
    }

    /**
     * Permet d'ajouter une voiture
     * @Route("/admin/voiture/new", name="voiture_add")
     * @Security("is_granted('ROLE_ADMIN')")
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

            return $this->redirectToRoute('voiture_edited_show', [
                'slug' => $voiture->getSlug()
            ]);
        }
        return $this->render('admin/voiture/add_voiture.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition de voiture
     * et d'effacer les Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/voiture/edit/{slug}", name="voiture_edit")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function edit_voiture(Voiture $voiture, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if (!$form->isSubmitted())
        {
            $this->addFlash(
                'danger',
                "/!\ Toutes les photos actuelles de la voiture <strong>{$voiture->getSlug()}</strong> seront éffacées et remplacées /!\ "
            );
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $voiture->getCoverImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            unlink("uploads/".$voiture->getCoverImage());
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

            return $this->redirectToRoute('voiture_edited_show', [
                'slug' => $voiture->getSlug()
            ]);
        }

        return $this->render('admin/voiture/edit_voiture.html.twig', [
            'form' => $form->createView(),
            'voiture' => $voiture
        ]);
    }

    /**
     * Permet d'éffacer une voiture et ses Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/voiture/delete/{slug}", name="voiture_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function delete_voiture(Voiture $voiture, ObjectManager $manager, VoitureRepository $repoVoiture)
    {
        $info = $voiture->getSlug();
        //ici on éfface toutes les images de la voiture 
        //dans la base de donnée et dans le dossier upload
        $images = $voiture->getImages();
        foreach ($images as $image)
        {
            //unlink sert à effacer le fichier dans uploads
            unlink( "uploads/".$image->getUrl() );
            $voiture->removeImage($image);
        }
        
        //ici on éfface la voiture 
        //dans la base de donnée
        $manager->remove($voiture);
        $manager->flush();

        $this->addFlash(
            'success',
            "La voiture <strong>$info</strong> a bien été supprimée !"
        );

        return $this->render('admin/voiture/index.html.twig', [
            'voitures' => $repoVoiture->findAll()
        ]);
    }

    /**
     * Permet d'afficher la voiture ajoutée
     *
     * @Route("/admin/voiture/edited/{slug}", name="voiture_edited_show")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function show_voiture_added(Voiture $voiture)
    {   
        return $this->render('admin/voiture/show_voiture_edited.html.twig', [
            'voiture' => $voiture
        ]);
    }
}
