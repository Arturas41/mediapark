<?php

namespace App\Form\Type;

use App\Entity\Country;
use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

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
            'allowed_countries' => null,
//            'allowed_countries' => ['Angola'],
//            'choice_loader' => ChoiceList::lazy($this, function() {
//                return $this->em->getRepository(SupportedCountry::class)->findAll();
//            }),
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'secret',
        ]);

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $allowedCountries = $options['allowed_countries'];

        //todo by_reference
        //todo form Data Transformers. for multiple text input seperated by space
        $builder
//            ->add('country', TextType::class)
//            ->add(
//                $builder->create('country', FormType::class, ['by_reference' => false])
//                    ->add('name', TextType::class)
//            )
//            ->add('LocaleType', LocaleType::class, [
//                'mapped' => false,
//            ])
//            ->add('LanguageType', LanguageType::class, [
//                'mapped' => false,
//            ])
//            ->add('CountryType', CountryType::class, [
//                'mapped' => false,
//            ])
            ->add('holidayType', CollectionType::class, [
                'mapped' => false,
                'entry_type' => holidayType::class,
            ])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'onPreSubmit']
            )
            ->add('RadioType', RadioType::class, [
                'mapped' => false,
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('FileType', FileType::class,
            [
                'mapped' => false,
            ])
            ->add('CheckboxType', CheckboxType::class, [
                'mapped' => false,
                'label'    => 'Show this entry publicly?',
                'required' => false,
            ])
            ->add('DateIntervalType', DateIntervalType::class, [
                'mapped' => false,
                'widget'      => 'integer', // render a text field for each part
                // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you

                // customize which text boxes are shown
                'with_years'  => true,
                'with_months' => false,
                'with_days'   => false,
                'with_hours'  => false,
            ])
            ->add('DateType', DateType::class, [
                'mapped' => false,
//                'widget' => 'choice',
                'widget' => 'single_text',
//                'placeholder' => [
//                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
//                ]
//                'format' => 'yyyy-MM-dd',
                'input' => 'array',
                'input_format' => 'yyyy-MM-dd'
            ])
            ->add('TimezoneType', TimezoneType::class, [
                'mapped' => false,
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
//                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'DESC');
                },
                'choice_label' => function ($country) {
                    return $country->getCode();
                }
//                'choices' => Country collection,
            ])
            ->add('fromDate', DateType::class, [
                'label' => 'Custom label',
            ])
            ->add('toDate', DateType::class)
            ->add('choiceTypeInput', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('supportedCountryInput', ChoiceType::class, [
                'mapped' => false,

//                'choices' => $this->em->getRepository(SupportedCountry::class)->findAll(),
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return $this->em->getRepository(SupportedCountry::class)->findAll();
                }),
                // "name" is a property path, meaning Symfony will look for a public
                // property or a public method like "getName()" to define the input
                // string value that will be submitted by the form
                'choice_value' => function (?SupportedCountry $entity) {
                    return $entity ? $entity->getId() : '';
                },
//                'choice_value' => 'id',
                // a callback to return the label for a given choice
                // if a placeholder is used, its empty value (null) may be passed but
                // its label is defined by its own "placeholder" option
                'choice_label' => function (?SupportedCountry $supportedCountry) {
                    return $supportedCountry->getCountry() ? $supportedCountry->getCountry()->getName() : '';
                },
                // returns the html attributes for each option input (may be radio/checkbox)
                'choice_attr' => function (?SupportedCountry $supportedCountry) {
                    return $supportedCountry ? ['class' => 'supported_country' . strtolower($supportedCountry->getId())] : [];
                },
                'choice_filter' => $allowedCountries ? ChoiceList::filter(
                    $this,
                    function ($supportedCountry) use ($allowedCountries) {
                        $countryName = $supportedCountry ? $supportedCountry->getCountry()->getName() : null;
                        return in_array($countryName, $allowedCountries, true);
                    },
                    $allowedCountries
                ) : null,
                'placeholder' => 'Choose an option',
                'required' => true,
                //todo can be calculated by user clicks
//                'preferred_choices' => ['muppets', 'arr'],
            ])
            ->add('stockStatus', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Main Statuses' => [
                        'Yes' => 'stock_yes',
                        'No' => 'stock_no',
                    ],
                    'Out of Stock Statuses' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
                    ],
                ],
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

    //todo use it
    public function onPreSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (isset($data)) {
            $form->add('onPreSetData1', TextType::class, ['mapped' => false,]);
        } else {
            $form->add('onPreSetData2', TextType::class, ['mapped' => false,]);
        }
    }
}