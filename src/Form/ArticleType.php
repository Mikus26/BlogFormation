<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleImageType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre de votre article',
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'titre',
                'expanded' => false,
                'multiple' => true,
                'by_reference' => false,
                'autocomplete' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.actif = true')
                        ->orderBy('c.titre', 'ASC');
                },
                'required' => false,
            ])
           
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Contenu de votre article',
                    'rows' => 5,
                ]
            ])
            ->add('actif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])

            ->add('images', CollectionType::class,[
                'label' => 'Images',
                'required' => false,
                'entry_type' => ArticleImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
