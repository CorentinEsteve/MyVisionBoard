<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'élément',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Texte',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ]
            ])
            // ->add('category', EntityType::class, [
            //     'label' => 'Catégorie',    
            //     'class' => Category::class, //Classe Entity utilisé pour notre champ
            //     'choice_label' => 'name',   //Attribut utilisé pour représenter l'Entity
            //     'expanded' => false,        //Affichage menu déroulant
            //     'multiple' => false,        //On ne sélectionner qu'UNE SEULE Category
            //     'attr' => [
            //         'class' => 'form-control mt-2 mb-3',
            //     ],
            // ])
            ->add('image', TextareaType::class, [
                'label' => 'Lien de l\'image',
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ],
                'required' => false
            ])

            ->add('upload', FileType::class, [
                'label' => 'Upload an image',
                'required' => false,
                'mapped'=> false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Poster l\'élément',
                'attr' => [
                    'style' => 'margin-top: 5px',
                    'class' => 'btn btn-success',
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
