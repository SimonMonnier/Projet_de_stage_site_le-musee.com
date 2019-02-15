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
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class, $this->getConfiguration("Marque  /!\Requis/!\ ", "Ex: Ferrari"))
            ->add('modele', TextType::class, $this->getConfiguration("Modèle  /!\Requis/!\ ", "Ex: 328 GTS"))
            ->add('carburant', TextType::class, $this->getConfiguration("Carburant  /!\Requis/!\ ", " Ex: Essence"))
            ->add('annee', IntegerType::class, $this->getConfiguration("Année  /!\Requis/!\ ", "Ex: 1968"))
            ->add('etat', TextType::class, $this->getConfiguration("Etat  /!\Requis/!\ ", "Ex: parfait état"))
            ->add('prix', MoneyType::class, $this->getConfiguration("Prix TTC  /!\Requis/!\ ", "Ex: 45000"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction de l'annonce  /!\Requis/!\ ", "Ex: La Ferrari 328 remplace le Ferrari 308 en septembre 1985 au Salon automobile de Francfort..."))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenue de l'annonce  /!\Requis/!\ ", "Ex: La Ferrari 328 remplace le Ferrari 308 en septembre 1985 au Salon automobile de Francfort. Les pare-chocs avant et arrière sont plus enveloppants et peints ton caisse et se dote d’un aileron arrière......"))
            ->add('type', TextType::class, $this->getConfiguration("Type", " Ex: F106ASR", [ 'required' => false ]))
            ->add('numeroSerie', TextType::class, $this->getConfiguration("Numéro de série", "Ex: ZFFWA20B000073991", [ 'required' => false ]))
            ->add('longueur', TextType::class, $this->getConfiguration("Longueur", "Ex: 426 CM", [ 'required' => false ]))
            ->add('largeur', TextType::class, $this->getConfiguration("Largeur", "Ex: 173 CM", [ 'required' => false ]))
            ->add('hauteur', TextType::class, $this->getConfiguration("Hauteur", "Ex: 113 CM", [ 'required' => false ]))
            ->add('poidsAVide', TextType::class, $this->getConfiguration("Poids à vide", " Ex: 1273 KG", [ 'required' => false ]))
            ->add('kilometrage', TextType::class, $this->getConfiguration("Kilomètrage", "Ex: 52039 Km", [ 'required' => false ]))
            ->add('puissance', TextType::class, $this->getConfiguration("Puissance", "Ex: 320 ch", [ 'required' => false ]))
            ->add('origine', TextType::class, $this->getConfiguration("Origine", "Ex: Italie", [ 'required' => false ]))
            ->add('boiteDeVitesse', TextType::class, $this->getConfiguration("Boite de vitesse", "Ex: automatique", [ 'required' => false ]))
            ->add('moteurEtCylindree', TextType::class, $this->getConfiguration("Moteur & Cylindrée", "Ex: V8 - 390 ci - 6,4 L", [ 'required' => false ]))
            ->add('CvFiscaux', TextType::class, $this->getConfiguration("CV fiscaux", "Ex: 37 cv", [ 'required' => false ]))
            ->add('conduite', TextType::class, $this->getConfiguration("Conduite", "Ex: à droite", [ 'required' => false ]))
            ->add('nombreDePlace', TextType::class, $this->getConfiguration("Nombre de place", "Ex: 4", [ 'required' => false ]))
            ->add('couleurCarrosserie', TextType::class, $this->getConfiguration("Couleur carrosserie", "Ex: Wimbledon white", [ 'required' => false ]))
            ->add('couleurInterieur', TextType::class, $this->getConfiguration("Couleur intérieur", "Ex: rouge", [ 'required' => false ]))
            ->add('carrosserie', TextType::class, $this->getConfiguration("Carrosserie", "Ex: Fastback", [ 'required' => false ]))
            ->add('coverImage', FileType::class, [ 'label' => 'Ajoutez une photo de la voiture pour la couverture', 'data_class' => null ])
            ->add('files', FileType::class, [ 'label' => 'Ajoutez des photos de la voiture pour l\'annonce  /!\Maintenez la touche "ctrl" pour sélectionner plusieures photos/!\ ','mapped' => false, 'multiple' => true, 'data_class' => null])
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
