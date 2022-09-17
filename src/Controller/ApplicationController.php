<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(UserInterface $user): Response
    {
        return $this->render('application/index.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }
}