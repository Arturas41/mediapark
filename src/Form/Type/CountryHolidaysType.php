<?php

namespace App\Form\Type;

use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryHolidaysType extends AbstractType
{

    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => SupportedCountry::class,
//        ]);
//    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('supportedCountry', EntityType::class, [
//                'class'       => SupportedCountry::class,
////                'class'       => 'App\Entity\SupportedCountry',
//                'choices' => $this->em->getRepository(SupportedCountry::class)->findAll();
//            ])
//        ;

//        //todo by_reference
//        //todo form Data Transformers. for multiple text input seperated by space
        $builder
            ->add('supportedCountry', EntityType::class, [
                'class' => SupportedCountry::class,
//                'class' => 'App\Entity\SupportedCountry',
//                'choice_loader' => new CallbackChoiceLoader(function () {
//                    return $this->em->getRepository(SupportedCountry::class)->findAll();
//                }),
                'choice_value' => function (?SupportedCountry $entity) {
                    return $entity ? $entity->getId() : '';
                },
                'choice_label' => function (?SupportedCountry $supportedCountry) {
                    return $supportedCountry->getCountry() ? $supportedCountry->getCountry()->getName() : '';
                },
                'choice_attr' => function (?SupportedCountry $supportedCountry) {
                    return ['class' => 'supported_country'];
                },
                'required' => true,
                'placeholder' => '',
            ]);
//            ->add('range', RangeType::class, [
//                'mapped' => false,
//                'attr' => [
//                    'min' => 5,
//                    'max' => 50
//                ]
//            ])
//            ->add('Submit', SubmitType::class);

        $formModifier = function (FormInterface $form, SupportedCountry $supportedCountry = null) {
            $fromDateYear = null === $supportedCountry ? [] : $supportedCountry->getFromDateYear();
            $form->add('randomInput', TextType::class, [
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data);
//                $formModifier($event->getForm(), $data->getSupportedCounty());
            }
        );

    }

//    //todo use it
//    public function onPreSubmit(FormEvent $event): void
//    {
//        $data = $event->getData();
//        $form = $event->getForm();
//
//        if (isset($data)) {
//            $form->add('onPreSetData1', TextType::class, ['mapped' => false,]);
//        } else {
//            $form->add('onPreSetData2', TextType::class, ['mapped' => false,]);
//        }
//    }
}