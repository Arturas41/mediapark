<?php

namespace App\Form\Type;

use App\Entity\Country;
use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
//            'data_class' => SupportedCountry::class,
        ]);
    }

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
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return $this->em->getRepository(Country::class)->findAll();
                }),
                'choice_value' => function (?Country $entity) {
                    return $entity ? $entity->getId() : '';
                },
                'choice_label' => function (?Country $entity) {
                    return $entity->getName();
                },
                'choice_attr' => function (?Country $entity) {
                    return ['class' => 'country'];
                },
                'required' => true,
            ])->add('Submit', SubmitType::class);

        $formModifier = function (FormInterface $form, Country $country = null) {
            $fromDateYear = null === $country ? [] : $country->getId();
            $form->add('randomInput', TextType::class, [
                'mapped' => false,
                'data' => $fromDateYear
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $country = $event->getData()->getCountry();
                $formModifier($event->getForm(), $country);
            }
        );

    }
}