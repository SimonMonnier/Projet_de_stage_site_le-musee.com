<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Voiture;
use App\Entity\Articles;
use App\Form\VoitureType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Form\ArticlesType;
use App\Repository\ImageRepository;
use App\Repository\VoitureRepository;
use App\Repository\ArticlesRepository;
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
        $user = new User();
        $adminRole = new Role();

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
                "L'administrateur {$user->getUsername()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('admin_admins_index');
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
            $password = $form["hash"]->getData();
            $hash = $this->encoder->encodePassword($user, $password);
            $user->setHash($hash);

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
    public function delete_admin(User $user, ObjectManager $manager, UserRepository $repoUser)
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'administrateur' a bien été supprimée !"
        );

        return $this->render('admin/index_admins.html.twig', [
            'users' => $repoUser->findAll()
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
     * affiche la totalité des voitures
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
    public function add_voiture(VoitureRepository $repoVoiture, Request $request, ObjectManager $manager)
    {
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = nl2br($request->get('Voiture')['content']);
            $voiture->setContent($content);
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

            return $this->render('admin/voiture/index.html.twig', [
                'voitures' => $repoVoiture->findAll()
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
    public function edit_voiture( VoitureRepository $repoVoiture, Voiture $voiture, Request $request, ObjectManager $manager)
    {   
        $fileinfo = $voiture->getCoverImage();

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if (!$form->isSubmitted())
        {
            $this->addFlash(
                'danger',
                "/!\ Toutes les photos actuelles de la voiture <strong>{$voiture->getSlug()}</strong> seront effacées et remplacées /!\ "
            );
        }
        if ($form->isSubmitted() && $form->isValid())
        {   
            $content = nl2br($request->get('Voiture')['content']);
            $voiture->setContent($content);

            unlink( "uploads/".$fileinfo );

            $file = $voiture->getCoverImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);

            $voiture->setCoverImage($filename);
            $voiture->setCreateAt(new \DateTime());

            //ici on efface toutes les anciennes images de la voiture 
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

            return $this->render('admin/voiture/index.html.twig', [
                'voitures' => $repoVoiture->findAll()
            ]);
        }

        return $this->render('admin/voiture/edit_voiture.html.twig', [
            'form' => $form->createView(),
            'voiture' => $voiture
        ]);
    }

    /**
     * Permet d'effacer une voiture et ses Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/voiture/delete/{slug}", name="voiture_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function delete_voiture(Voiture $voiture, ObjectManager $manager, VoitureRepository $repoVoiture)
    {
        $fileinfo = $voiture->getCoverImage();
        $info = $voiture->getSlug();
        //ici on efface toutes les images de la voiture 
        //dans la base de donnée et dans le dossier upload
        $images = $voiture->getImages();
        unlink( "uploads/".$fileinfo );
        foreach ($images as $image)
        {   dump($image);
            //unlink sert à effacer le fichier dans uploads
            unlink( "uploads/".$image->getUrl() );
            $voiture->removeImage($image);
        }
        
        //ici on efface la voiture 
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

    /**
     * affiche la totalité des articles
     *@Route("/admin/articles", name="admin_articles_index")
     * @param ArticlesRepository $repoArticles
     * @return Response
     */
    public function index_articles(ArticlesRepository $repoArticles) 
    {
        $this->addFlash(
            'danger',
            "/!\Lorsque vous modifiez un article, vous avez l'obligation de re-télécharger ses photos.Pensez à conserver les photos (Ex: clé usb, disque dur)/!\ "
        );
        return $this->render('admin/articles/index.html.twig', [
            'articles' => $repoArticles->findAll()
        ]);
    }

    /**
     * Permet d'ajouter un article
     * @Route("/admin/article/new", name="article_add")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function add_article(Request $request, ObjectManager $manager, ArticlesRepository $repoArticles)
    {
        $article = new Articles();

        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $introduction = nl2br($request->get('articles')['introduction']);
            $paragraphe1 = nl2br($request->get('articles')['paragraphe1']);
            $paragraphe2 = nl2br($request->get('articles')['paragraphe2']);
            $paragraphe3 = nl2br($request->get('articles')['paragraphe3']);
            $paragraphe4 = nl2br($request->get('articles')['paragraphe4']);
            $paragraphe5 = nl2br($request->get('articles')['paragraphe5']);
            $paragraphe6 = nl2br($request->get('articles')['paragraphe6']);
            $paragraphe7 = nl2br($request->get('articles')['paragraphe7']);
            $paragraphe8 = nl2br($request->get('articles')['paragraphe8']);
            $paragraphe9 = nl2br($request->get('articles')['paragraphe9']);
            $paragraphe10 = nl2br($request->get('articles')['paragraphe10']);
            
            $article->setIntroduction($introduction)
                    ->setParagraphe1($paragraphe1)
                    ->setParagraphe2($paragraphe2)
                    ->setParagraphe3($paragraphe3)
                    ->setParagraphe4($paragraphe4)
                    ->setParagraphe5($paragraphe5)
                    ->setParagraphe6($paragraphe6)
                    ->setParagraphe7($paragraphe7)
                    ->setParagraphe8($paragraphe8)
                    ->setParagraphe9($paragraphe9)
                    ->setParagraphe10($paragraphe10);

            $file = $article->getCoverImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $article->setCoverImage($filename);

            $file = $article->getImage1();
            if($file != NULL)
            {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage1($filename);
            }

            $file = $article->getImage2();
            if ($file != null)
            {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage2($filename);
            }

            $file = $article->getImage3();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage3($filename);
            }

            $file = $article->getImage4();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage4($filename);
            }

            $file = $article->getImage5();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage5($filename);
            }

            $file = $article->getImage6();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage6($filename);
            }

            $file = $article->getImage7();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage7($filename);
            }

            $file = $article->getImage8();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage8($filename);
            }

            $file = $article->getImage9();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage9($filename);
            }

            $file = $article->getImage10();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage10($filename);
            }

            $article->setCreatedAt(new \DateTime());
            
            $manager->persist($article);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'article <strong>{$article->getSlug()}</strong> a bien été enregistrée !"
            );
           
            return $this->render('admin/articles/index.html.twig', [
                'articles' => $repoArticles->findAll()
            ]);

        }
        return $this->render('admin/articles/add_article.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * et d'effacer les Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/article/edit/{slug}", name="article_edit")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function edit_article(ArticlesRepository $repoArticles, Articles $article, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ArticlesType::class, $article);

        $fileinfo = $article->getCoverImage();
        $fileinfo1 = $article->getImage1();
        $fileinfo2 = $article->getImage2();
        $fileinfo3 = $article->getImage3();
        $fileinfo4 = $article->getImage4();
        $fileinfo5 = $article->getImage5();
        $fileinfo6 = $article->getImage6();
        $fileinfo7 = $article->getImage7();
        $fileinfo8 = $article->getImage8();
        $fileinfo9 = $article->getImage9();
        $fileinfo10 = $article->getImage10();

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $this->addFlash(
                'danger',
                "/!\ Toutes les photos actuelles de l'article <strong>{$article->getSlug()}</strong> seront effacées et remplacées /!\ "
            );
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            $introduction = nl2br($request->get('articles')['introduction']);
            $paragraphe1 = nl2br($request->get('articles')['paragraphe1']);
            $paragraphe2 = nl2br($request->get('articles')['paragraphe2']);
            $paragraphe3 = nl2br($request->get('articles')['paragraphe3']);
            $paragraphe4 = nl2br($request->get('articles')['paragraphe4']);
            $paragraphe5 = nl2br($request->get('articles')['paragraphe5']);
            $paragraphe6 = nl2br($request->get('articles')['paragraphe6']);
            $paragraphe7 = nl2br($request->get('articles')['paragraphe7']);
            $paragraphe8 = nl2br($request->get('articles')['paragraphe8']);
            $paragraphe9 = nl2br($request->get('articles')['paragraphe9']);
            $paragraphe10 = nl2br($request->get('articles')['paragraphe10']);

            $article->setIntroduction($introduction)
                    ->setParagraphe1($paragraphe1)
                    ->setParagraphe2($paragraphe2)
                    ->setParagraphe3($paragraphe3)
                    ->setParagraphe4($paragraphe4)
                    ->setParagraphe5($paragraphe5)
                    ->setParagraphe6($paragraphe6)
                    ->setParagraphe7($paragraphe7)
                    ->setParagraphe8($paragraphe8)
                    ->setParagraphe9($paragraphe9)
                    ->setParagraphe10($paragraphe10);
                    
            $file = $article->getCoverImage();
            unlink("uploads/".$fileinfo);
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $article->setCoverImage($filename);
            $article->setCreatedAt(new \DateTime());

            if($fileinfo1 != NULL)
            {
                unlink("uploads/" . $fileinfo1);
            }
            if ($fileinfo2 != null) {
                unlink("uploads/" . $fileinfo2);
            }
            if ($fileinfo3 != null) {
                unlink("uploads/" . $fileinfo3);
            }
            if ($fileinfo4 != null) {
                unlink("uploads/" . $fileinfo4);
            }
            if ($fileinfo5 != null) {
                unlink("uploads/" . $fileinfo5);
            }
            if ($fileinfo6 != null) {
                unlink("uploads/" . $fileinfo6);
            }
            if ($fileinfo7 != null) {
                unlink("uploads/" . $fileinfo7);
            }
            if ($fileinfo8 != null) {
                unlink("uploads/" . $fileinfo8);
            }
            if ($fileinfo9 != null) {
                unlink("uploads/" . $fileinfo9);
            }
            if ($fileinfo10 != null) {
                unlink("uploads/" . $fileinfo10);
            }

            $file = $article->getImage1();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage1($filename);
            }

            $file = $article->getImage2();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage2($filename);
            }

            $file = $article->getImage3();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage3($filename);
            }

            $file = $article->getImage4();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage4($filename);
            }

            $file = $article->getImage5();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage5($filename);
            }

            $file = $article->getImage6();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage6($filename);
            }

            $file = $article->getImage7();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage7($filename);
            }

            $file = $article->getImage8();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage8($filename);
            }

            $file = $article->getImage9();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage9($filename);
            }

            $file = $article->getImage10();
            if ($file != null) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $filename);
                $article->setImage10($filename);
            }

            $manager->persist($article);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "Les modifications de l'article <strong>{$article->getSlug()}</strong> ont bien été enregistrées !"
            );

            return $this->render('admin/articles/index.html.twig', [
                'articles' => $repoArticles->findAll()
            ]);
        }

        return $this->render('admin/articles/edit_article.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * Permet d'effacer un article et ses Photos dans la base de donnée et le dossier uploads
     *
     * @Route("/admin/article/delete/{slug}", name="article_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function delete_article(Articles $article, ObjectManager $manager, ArticlesRepository $repoArticle)
    {
        $info = $article->getSlug();

        //ici on efface toutes les images de la article 
        //dans la base de donnée et dans le dossier upload
        $fileinfo = $article->getCoverImage();
        $fileinfo1 = $article->getImage1();
        $fileinfo2 = $article->getImage2();
        $fileinfo3 = $article->getImage3();
        $fileinfo4 = $article->getImage4();
        $fileinfo5 = $article->getImage5();
        $fileinfo6 = $article->getImage6();
        $fileinfo7 = $article->getImage7();
        $fileinfo8 = $article->getImage8();
        $fileinfo9 = $article->getImage9();
        $fileinfo10 = $article->getImage10();


        if ($fileinfo != null) {
            unlink("uploads/" . $fileinfo);
        }
        if ($fileinfo1 != null) {
            unlink("uploads/" . $fileinfo1);
        }
        if ($fileinfo2 != null) {
            unlink("uploads/" . $fileinfo2);
        }
        if ($fileinfo3 != null) {
            unlink("uploads/" . $fileinfo3);
        }
        if ($fileinfo4 != null) {
            unlink("uploads/" . $fileinfo4);
        }
        if ($fileinfo5 != null) {
            unlink("uploads/" . $fileinfo5);
        }
        if ($fileinfo6 != null) {
            unlink("uploads/" . $fileinfo6);
        }
        if ($fileinfo7 != null) {
            unlink("uploads/" . $fileinfo7);
        }
        if ($fileinfo8 != null) {
            unlink("uploads/" . $fileinfo8);
        }
        if ($fileinfo9 != null) {
            unlink("uploads/" . $fileinfo9);
        }
        if ($fileinfo10 != null) {
            unlink("uploads/" . $fileinfo10);
        }
        
        //ici on efface l'article
        //dans la base de donnée
        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'article' <strong>$info</strong> a bien été supprimé !"
        );

        return $this->render('admin/articles/index.html.twig', [
            'articles' => $repoArticle->findAll()
        ]);
    }

    /**
     * Permet d'afficher l'article ajouté
     *
     * @Route("/admin/article/edited/{slug}", name="article_edited_show")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function show_article_added(Articles $article)
    {
        return $this->render('admin/articles/show_article_edited.html.twig', [
            'article' => $article
        ]);
    }
}