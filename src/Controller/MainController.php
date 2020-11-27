<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\SupportedCountry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {

        $supportedCountry = new SupportedCountry();
//        $supportedCountry->setCountry($country);
        $supportedCountry->setToDate(new \DateTime('tomorrow'));
        $supportedCountry->setFromDate(new \DateTime('tomorrow'));

        $form = $this->createForm(SupportedCountryType::class, $supportedCountry, [

        ]);

        //todo Dynamic Generation for Submitted Forms
        //todo constraints/validation
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }


        return $this->render('main/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}