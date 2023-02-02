<?php

namespace App\Controller;

use App\Entity\Journee;
use App\Entity\UserJournee;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddJourneeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JourneeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine, EntityManagerInterface $em, Journee $journee): Response
    {
        $user = $this->getUser();
        $list = $doctrine->getRepository(UserJournee::class)->findOneBy(array('journee' => $journee));
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'journee' => $journee,
            'user' => $user,
            'list' => $list,
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
            $liste = new UserJournee();
            $liste->setJournee($journee);
            $liste->setValidation(false);
            $liste->setUser($user);
            $em->persist($journee);
            $em->persist($liste);
            $em->flush();
        }

        return $this->renderForm('journee/add.html.twig', compact('journeeForm'));
        }
    }

    public function addParticipant(ManagerRegistry $doctrine, EntityManagerInterface $em, Journee $journee): Response{
        $user = $this->getUser();
        $list = new UserJournee();
        $list->setJournee($journee);
        $list->setValidation(false);
        $list->setUser($user);
        $em->persist($list);
        $em->flush();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'JourneeController',
            'list' => $list,
            'user' => $user,
        ]);
    }

    public function checkParticipants(ManagerRegistry $doctrine, Journee $journee): Response{
        $idjournee = $journee->getId();
        $list = $doctrine->getRepository(UserJournee::class)->findOneBy(array('journee' => $journee));
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'list' => $list,
        ]);
    }
}
