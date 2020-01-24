<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SanhiorImageController extends AbstractController
{
    /**
     * @Route("/sanhior/image", name="sanhior_image")
     */
    public function index()
    {
        return $this->render('sanhior_image/index.html.twig', [
            'controller_name' => 'SanhiorImageController',
        ]);
    }
}
