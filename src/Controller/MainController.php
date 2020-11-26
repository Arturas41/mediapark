<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\SupportedCountryType;


class MainController extends AbstractController
{
    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

     /**
      * @Route("/", name="main_show")
      */
    public function show(): Response
    {
//        $country = $this->em->getRepository(Country::class)->findOneBy(
//            ['name' => 'Denmark']
//        );

        $supportedCountry = new SupportedCountry();
//        $supportedCountry->setCountry($country);
        $supportedCountry->setToDate(new \DateTime('tomorrow'));
        $supportedCountry->setFromDate(new \DateTime('tomorrow'));

        $form = $this->createForm(SupportedCountryType::class, $supportedCountry);

        return $this->render('main/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}