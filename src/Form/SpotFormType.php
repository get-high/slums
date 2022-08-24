<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Spot;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class SpotFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $spot = $options['data'] ?? null;

        $createdSpot = $spot && $spot->getId();

        $builder
            ->add('title', null, [
                'label' => 'Название объекта',
            ])
            ->add('slug', null, [
                'label' => 'Slug (только латинские буквы, _ и цифры)',
            ])
            ->add('address', null, [
                'label' => 'Полный адрес',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Краткое описание',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'История объекта',
                'config' => array(
                    'uiColor' => '#ffffff',
                ),
            ])
            ->add('how_to_get', TextareaType::class, [
                'label' => 'Как добраться',
                'required' => false,
            ])
            ->add('lat', null, [
                'label' => 'Широта',
            ])
            ->add('lng', null, [
                'label' => 'Долгота',
            ])
            ->add('main', CheckboxType::class, [
                'label' => 'Отображать на главной?',
                'required' => false,
            ])
            ->add('years', null, [
                'label' => 'Годы создания',
            ])
            ->add('authors', null, [
                'label' => 'Авторы',
            ])
            ->add('image', FileType::class, [
                'label' => 'Изображение (Jpeg, минимум 700 на 500 px)',
                'mapped' => false,
                'required' => ! $createdSpot,
                'constraints' => new Image([
                    'mimeTypes' => [
                        'image/jpeg'
                    ],
                    'minWidth' => 700,
                    'minHeight' => 500,
                ]),
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Категории',
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
