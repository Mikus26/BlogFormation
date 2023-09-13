<?php

namespace App\Form;

use App\Entity\ArticleImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageFile', VichImageType::class, [
            'label' => 'Image:',
            'required' => false,
            'allow_delete' => false,
            'delete_label' => 'Supprimer l\'image',
            'download_uri' => false,
            'image_uri' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleImage::class,
        ]);
    }
}
