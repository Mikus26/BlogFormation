<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Categorie;
use App\Search\SearchArticle;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Rechercher'],
                'required' => false,
            ])

            ->add('tags', EntityType::class, [
                'label' => false,
                'class' => Categorie::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.actif = true')
                        ->innerJoin('c.articles', 'a')
                        ->orderBy('c.titre', 'asc')
                        ;
                }
            ])

            ->add('authors', EntityType::class,[
                'label' => 'authors',
                'class' => User::class,
                'choice_label' => 'fullName',
                'multiple' => true,
                'expanded'=>true,
                'required' => false,
                'query_builder' => function (EntityRepository $er): QueryBuilder{
                    return $er->createQueryBuilder('u')
                    ->innerJoin('u.articles','a')
                    ->orderBy('u.firstName', 'ASC')
                    ;
                }
        
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => SearchArticle::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
