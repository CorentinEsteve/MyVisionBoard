<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Element title',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-2 mb-3',
                ]
            ])
            ->add('image', TextareaType::class, [
                'label' => 'Image link',
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
