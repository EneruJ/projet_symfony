<?php

namespace App\Controller;

use App\Entity\Journee;
use App\Entity\Participants;
use Doctrine\Persistence\ManagerRegistry;
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
            $liste = new Participants();
            $liste->setJournee($journee);
            $em->persist($journee);
            $em->persist($liste);
            $em->flush();
        }

        return $this->renderForm('journee/add.html.twig', compact('journeeForm'));
        }
    }

    public function addParticipant(ManagerRegistry $doctrine, EntityManagerInterface $em, Journee $journee): Response{
        $user = $this->getUser();
        $list = $doctrine->getRepository(Participants::class)->findOneBy(array('journee' => $journee));
        $list->addParticipant($user);
        $em->flush();
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'list' => $list,
        ]);
    }

    public function checkParticipants(ManagerRegistry $doctrine, Journee $journee): Response{
        $idjournee = $journee->getId();
        $list = $doctrine->getRepository(Participants::class)->findOneBy(array('journee' => $journee));
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'list' => $list,
        ]);
    }
}
