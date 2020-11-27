<?php

namespace App\Form\Type;

use App\Entity\SupportedCountry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportedCountryType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportedCountry::class,
            'is_required_to_date' => false,
        ]);

        $resolver->setAllowedTypes('is_required_to_date', 'bool');
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('country', TextType::class)

            ->add('fromDate', DateType::class, [
                'label' => 'Custom label',
                'required' => $options['is_required_to_date'],
            ])
            ->add('toDate', DateType::class)
            ->add('choiceType', ChoiceType::class, [
                'choices' => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
                'label' => 'choiceType',
                'mapped' => false
            ])
            ->add('save', SubmitType::class);
    }
}