<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InitController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        #1
        $contents = $this->renderView('home/index.html.twig');
        return new Response($contents);

        #2
        // return $this->render('home/index.html.twig');
    }
}
