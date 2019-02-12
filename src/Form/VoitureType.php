<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('marque')
            ->add('introduction')
            ->add('content')
            ->add('modèle')
            ->add('année')
            ->add('type')
            ->add('numéroSérie')
            ->add('longueur')
            ->add('largeur')
            ->add('hauteur')
            ->add('poidsAVide')
            ->add('carburant')
            ->add('kilomètrage')
            ->add('couleurCarrosserie')
            ->add('couleurIntérieur')
            ->add('puissance')
            ->add('origine')
            ->add('boiteDeVitesse')
            ->add('moteurEtCylindrée')
            ->add('CvFiscaux')
            ->add('conduite')
            ->add('nombreDePlace')
            ->add('carrosserie')
            ->add('état')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
