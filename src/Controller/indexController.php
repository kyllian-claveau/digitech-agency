<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends AbstractController
{
    #[Route("/", name: "app_home")]
    function index()
    {
        return $this->render("index.html.twig");
    }
}