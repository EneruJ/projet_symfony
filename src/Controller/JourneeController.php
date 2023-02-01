<?php

namespace App\Controller;

use App\Entity\Journee;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddJourneeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JourneeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
        ]);
    }

    public function add(Request $request, EntityManagerInterface $em): Response
    {
        {
        $journee = new Journee();

        $journeeForm = $this->createForm(AddJourneeType::class, $journee);

        $journeeForm->handleRequest($request);

        if($journeeForm->isSubmitted() && $journeeForm->isValid()){
            $user = $this->getUser();
            $journee->setOrganisateur($user);
            $em->persist($journee); 
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}
}
