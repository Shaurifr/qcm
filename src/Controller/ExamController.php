<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamController extends AbstractController
{
    /**
     * @Route("/exam", name="exam")
     */
    public function index(): Response
    {
        return $this->render('exam/index.html.twig', [
            'controller_name' => 'ExamController',
        ]);
    }
}
