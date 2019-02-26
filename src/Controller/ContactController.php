<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Voiture;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     *
     */
    public function contact(Request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = $request->get('contact')['message'];
            $contact->setMessage($message);
            $manager->persist($contact);

            $manager->flush();

            $this->addFlash(
                'success',
                "Votre message a été envoyé, nous y répondrons dans les plus brefs délais !"            
            );

            $message = ( new \Swift_Message ('Demande d\'information'))
                        ->setFrom('s.monnier44440@gmail.com')
                        ->setTo( 's.monnier44440@gmail.com')
                        ->setBody($this->renderView('contact/email.html.twig', [
                            'contact' => $contact                      
                            ]), 'text/html'
                            
                        );

            $mailer->send($message);

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
