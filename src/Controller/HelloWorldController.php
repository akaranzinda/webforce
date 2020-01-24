<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController //modele C -> Controller
{
    /**
     * @Route("/hello/world", name="hello_world")
     */
    public function index()  
    {
        return $this->render('hello_world/index.html.twig', [ //vue
            'controller_name' => 'HelloWorldController',
        ]);
    }
}
