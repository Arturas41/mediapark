<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
     /**
      * @Route("/", name="main_show")
      */
    public function show(): Response
    {
        $tests = ['test1', 'test2', 'test3'];

        return $this->render('main/layout.html.twig', [
            'tests' => $tests
        ]);
    }
}