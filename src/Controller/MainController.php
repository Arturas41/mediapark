<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
     /**
      * @Route("/", name="blog_list")
      */
    public function show(): Response
    {
        return new Response(
            '<html><body>MainController show</body></html>'
        );
    }
}