<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticlesType extends AbstractType
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
            ->add('titre', TextType::class, $this->getConfiguration("Titre de l'article", "Mon article"))
            ->add('coverImage', FileType::class, ['label' => 'Ajoutez une photo de la voiture pour la couverture', 'data_class' => null])
            ->add('introduction', TextareaType::class, $this->getConfiguration("Introduction de l'article", ""))
            ->add('image1', FileType::class, ['label' => 'Ajoutez la photo n°1', 'data_class' => null, 'required' => false])
            ->add('paragraphe1', TextareaType::class, $this->getConfiguration("Paragraphe n°1", "", ['required' => false]))
            ->add('image2', FileType::class, ['label' => 'Ajoutez la photo n°2', 'data_class' => null , 'required' => false])
            ->add('paragraphe2', TextareaType::class, $this->getConfiguration("Paragraphe n°2", "", ['required' => false]))
            ->add('image3', FileType::class, ['label' => 'Ajoutez la photo n°3', 'data_class' => null, 'required' => false])
            ->add('paragraphe3', TextareaType::class, $this->getConfiguration("Paragraphe n°3", "", ['required' => false]))
            ->add('image4', FileType::class, ['label' => 'Ajoutez la photo n°4', 'data_class' => null , 'required' => false])
            ->add('paragraphe4', TextareaType::class, $this->getConfiguration("Paragraphe n°4", "", ['required' => false]))
            ->add('image5', FileType::class, ['label' => 'Ajoutez la photo n°5', 'data_class' => null , 'required' => false])
            ->add('paragraphe5', TextareaType::class, $this->getConfiguration("Paragraphe n°5", "", ['required' => false]))
            ->add('image6', FileType::class, ['label' => 'Ajoutez la photo n°6', 'data_class' => null , 'required' => false])
            ->add('paragraphe6', TextareaType::class, $this->getConfiguration("Paragraphe n°6", "", ['required' => false]))
            ->add('image7', FileType::class, ['label' => 'Ajoutez la photo n°7', 'data_class' => null , 'required' => false])
            ->add('paragraphe7', TextareaType::class, $this->getConfiguration("Paragraphe n°7", "", ['required' => false]))
            ->add('image8', FileType::class, ['label' => 'Ajoutez la photo n°8', 'data_class' => null , 'required' => false])
            ->add('paragraphe8', TextareaType::class, $this->getConfiguration("Paragraphe n°8", "", ['required' => false])) 
            ->add('image9', FileType::class, ['label' => 'Ajoutez la photo n°9', 'data_class' => null , 'required' => false])
            ->add('paragraphe9', TextareaType::class, $this->getConfiguration("Paragraphe n°9", "", ['required' => false]))
            ->add('image10', FileType::class, ['label' => 'Ajoutez la photo n°10', 'data_class' => null , 'required' => false])
            ->add('paragraphe10', TextareaType::class, $this->getConfiguration("Paragraphe n°10", "", ['required' => false]))
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
