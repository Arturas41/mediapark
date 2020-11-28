<?php

namespace App\Form\Type;

use App\Entity\Country;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class CountryHolidaysType extends AbstractType
{

    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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

        $formModifier = function (FormInterface $form, Country $country) {
            $fromDateYear = $country->getSupportedCountry()->getFromDateYear();
            $toDateYear = $country->getSupportedCountry()->getToDateYear();
            $form->add('year', IntegerType::class, [
                'mapped' => false,
                'attr' => [
                    'min' => $fromDateYear,
                    'max' => $toDateYear
                ],
                'required' => true,
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