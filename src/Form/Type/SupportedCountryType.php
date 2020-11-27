<?php

namespace App\Form\Type;

use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportedCountryType extends AbstractType
{

    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportedCountry::class,
        ]);

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('country', TextType::class)

            ->add('fromDate', DateType::class, [
                'label' => 'Custom label',
            ])
            ->add('toDate', DateType::class)



            ->add('choiceTypeInput', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
            ])


            ->add('supportedCountryInput', ChoiceType::class, [
                'mapped' => false,
                'choices' => $this->em->getRepository(SupportedCountry::class)->findAll(),
                // "name" is a property path, meaning Symfony will look for a public
                // property or a public method like "getName()" to define the input
                // string value that will be submitted by the form
                'choice_value' => 'id',
                // a callback to return the label for a given choice
                // if a placeholder is used, its empty value (null) may be passed but
                // its label is defined by its own "placeholder" option
                'choice_label' => function(?SupportedCountry $supportedCountry) {
                    return $supportedCountry->getCountry() ? $supportedCountry->getCountry()->getName() : '';
                },
                // returns the html attributes for each option input (may be radio/checkbox)
                'choice_attr' => function(?SupportedCountry $supportedCountry) {
                    return $supportedCountry ? ['class' => 'supported_country'.strtolower($supportedCountry->getId())] : [];
                },
                // every option can use a string property path or any callable that get
                // passed each choice as argument, but it may not be needed
//                'group_by' => function() {
//                    // randomly assign things into 2 groups
//                    return rand(0, 1) == 1 ? 'Group A' : 'Group B';
//                },
                // a callback to return whether a category is preferred
//                'preferred_choices' => function(?SupportedCountry $supportedCountry) {
//                    return $supportedCountry->getId();
//                },
            ])




            ->add('textField', TextareaType::class, [
                'data' => 'abcdef',
                'attr' => ['class' => 'tinymce'],
                'mapped' => false,
                'empty_data' => 'John Doe',
                'help' => 'The ZIP/Postal code for your credit card\'s billing address.',
                'compound' => true,
            ])
            ->add('price', MoneyType::class, [
                'divisor' => 100,
                'mapped' => false,
                'currency' => 'EUR',
                'scale' => 4,
            ])
            ->add('url', UrlType::class, [
                'mapped' => false,
                'default_protocol' => 'ftp://',
            ])
            ->add('range', RangeType::class, [
                'mapped' => false,
                'attr' => [
                    'min' => 5,
                    'max' => 50
                ]
            ])
            ->add('color', ColorType::class, [
                'mapped' => false,
            ])


            ->add('save', SubmitType::class);
    }
}