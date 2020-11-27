<?php

namespace App\Form\Type;

use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
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
        //todo by_reference
        //todo form Data Transformers. for multiple text input seperated by space
        $builder
            ->add('supportedCountry', ChoiceType::class, [
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return $this->em->getRepository(SupportedCountry::class)->findAll();
                }),
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
            ])
//            ->add('range', RangeType::class, [
//                'mapped' => false,
//                'attr' => [
//                    'min' => 5,
//                    'max' => 50
//                ]
//            ])
            ->add('Submit', SubmitType::class);
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