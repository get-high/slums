<?php

namespace App\Form;

use App\Form\Model\CreateSpotFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CreateSpotFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('address', null, [
                'label' => 'Адрес',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Краткое описание',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'История объекта',
                'required' => false,
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
            ->add('years')
            ->add('authors')
            ->add('image', FileType::class, [
                'mapped' => false,
                'constraints' => new Image([
                    'mimeTypes' => [
                        'image/jpeg'
                    ],
                    'minWidth' => 700,
                    'minHeight' => 500,
                ]),
            ])
            //->add('creator')
            //->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateSpotFormModel::class,
        ]);
    }
}
