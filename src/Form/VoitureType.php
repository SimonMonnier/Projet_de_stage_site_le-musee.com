<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VoitureType extends AbstractType
{
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class, $this->getConfiguration("Marque /!\Requis/!\ ", "Ex: Ferrari"))
            ->add('modele', TextType::class, $this->getConfiguration("Modèle /!\Requis/!\ ", "Ex: 328 GTS"))
            ->add('carburant', TextType::class, $this->getConfiguration("Carburant /!\Requis/!\ ", " Ex: Essence"))
            ->add('annee', IntegerType::class, $this->getConfiguration("Année /!\Requis/!\ ", "Ex: 1968"))
            ->add('etat', TextType::class, $this->getConfiguration("Etat /!\Requis/!\ ", "Ex: parfait état"))
            ->add('prix', MoneyType::class, $this->getConfiguration("Prix TTC  /!\Requis/!\ ", "Ex: 45000"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction de l'annonce /!\Requis/!\ ", "Ex: La Ferrari 328 remplace le Ferrari 308 en septembre 1985 au Salon automobile de Francfort..."))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenue de l'annonce  /!\Requis/!\ ", "Ex: La Ferrari 328 remplace le Ferrari 308 en septembre 1985 au Salon automobile de Francfort. Les pare-chocs avant et arrière sont plus enveloppants et peints ton caisse et se dote d’un aileron arrière......"))
            ->add('type', TextType::class, $this->getConfiguration("Type", " Ex: F106ASR"))
            ->add('numeroSerie', TextType::class, $this->getConfiguration("Numéro de série", "Ex: ZFFWA20B000073991"))
            ->add('longueur', TextType::class, $this->getConfiguration("Longueur", "Ex: 426 CM"))
            ->add('largeur', TextType::class, $this->getConfiguration("Largeur", "Ex: 173 CM"))
            ->add('hauteur', TextType::class, $this->getConfiguration("Hauteur", "Ex: 113 CM"))
            ->add('poidsAVide', TextType::class, $this->getConfiguration("Poids à vide", " Ex: 1273 KG"))
            ->add('kilometrage', TextType::class, $this->getConfiguration("Kilomètrage", "Ex: 52039 Km"))
            ->add('puissance', TextType::class, $this->getConfiguration("Puissance", "Ex: 320 ch"))
            ->add('origine', TextType::class, $this->getConfiguration("Origine", "Ex: Italie"))
            ->add('boiteDeVitesse', TextType::class, $this->getConfiguration("Boite de vitesse", "Ex: automatique"))
            ->add('moteurEtCylindree', TextType::class, $this->getConfiguration("Moteur & Cylindrée", "Ex: V8 - 390 ci - 6,4 L"))
            ->add('CvFiscaux', TextType::class, $this->getConfiguration("CV fiscaux", "Ex: 37 cv"))
            ->add('conduite', TextType::class, $this->getConfiguration("Conduite", "Ex: à droite"))
            ->add('nombreDePlace', TextType::class, $this->getConfiguration("Nombre de place", "Ex: 4"))
            ->add('couleurCarrosserie', TextType::class, $this->getConfiguration("Couleur carrosserie", "Ex: Wimbledon white"))
            ->add('couleurInterieur', TextType::class, $this->getConfiguration("Couleur intérieur", "Ex: rouge"))
            ->add('carrosserie', TextType::class, $this->getConfiguration("Carrosserie", "Ex: Fastback"))
            ->add('coverImage', FileType::class, [ 'label' => 'Ajoutez la photo de la voiture pour la couverture'])
            ->add('files', FileType::class, [ 'label' => 'Ajoutez les photos de la voiture pour l\'annonce','mapped' => false, 'multiple' => true])
            ->add('Enregistrer', SubmitType::class,[
                'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class
        ]);
    }
}
