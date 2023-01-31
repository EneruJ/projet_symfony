<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Journee;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $list = $doctrine->getRepository(Journee::class)->findAll();
        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list' => $list,
            'user' => $user,
        ]);
    }

}
