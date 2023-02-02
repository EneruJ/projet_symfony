<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Journee;
use App\Entity\Commentaire;
use App\Entity\UserJournee;
use App\Entity\Images;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddJourneeType;
use App\Form\CommentaireFormType;
use App\Form\ImageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JourneeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine, EntityManagerInterface $em, Journee $journee, Request $request): Response
    {
        $user = $this->getUser();
        $list = $doctrine->getRepository(UserJournee::class)->findBy(array('journee' => $journee));
        $list_comment = $doctrine->getRepository(Commentaire::class)->findBy(array('journee' => $journee));
        $list_image = $doctrine->getRepository(Images::class)->findBy(array('journee' => $journee));

        $Commentaire = new Commentaire();
        $CommentaireForm = $this->createForm(CommentaireFormType::class, $Commentaire);
        $CommentaireForm->handleRequest($request);

        if($CommentaireForm->isSubmitted() && $CommentaireForm->isValid()){
            $user = $this->getUser();
            $Commentaire->setUser($user);
            $Commentaire->setJournee($journee);
            $em->persist($Commentaire);
            $em->flush();
        }

        $image = new Images();
        $imageForm = $this->createForm(ImageFormType::class, $image);
        $imageForm->handleRequest($request);

        if($imageForm->isSubmitted() && $imageForm->isValid()){
            $image->setJournee($journee);
            $em->persist($image);
            $em->flush();
        }

        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'journee' => $journee,
            'user' => $user,
            'list' => $list,
            'form' => $CommentaireForm->createView(),
            'list_comment' => $list_comment,
            'form_image' => $imageForm->createView(),
            'list_image' => $list_image,
        ]);
    }

    public function add(Request $request, EntityManagerInterface $em): Response
    {
        
        $journeenew = new Journee();

        $journeeForm = $this->createForm(AddJourneeType::class, $journeenew);

        $journeeForm->handleRequest($request);

        if($journeeForm->isSubmitted() && $journeeForm->isValid()){
            $user = $this->getUser();
            $journeenew->setOrganisateur($user);
            $liste = new UserJournee();
            $liste->setJournee($journeenew);
            $liste->setValidation(true);
            $liste->setUser($user);
            $em->persist($journeenew);
            $em->persist($liste);
            $em->flush();
        }

        return $this->renderForm('journee/add.html.twig', compact('journeeForm'));
        
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

    public function validateUser(ManagerRegistry $doctrine,EntityManagerInterface $em,  Journee $journee, User $user): Response{
        $list = $doctrine->getRepository(UserJournee::class)->findOneBy(array('journee' => $journee, 'user' => $user));
        $journees = $doctrine->getRepository(Journee::class)->findAll();
        $list->setValidation(true);
        $em->flush();
        $userp = $this->getUser();
        $liste = $doctrine->getRepository(UserJournee::class)->findBy(array('journee' => $journee));
        return $this->render('journee/index.html.twig', [
            'controller_name' => 'JourneeController',
            'journee' => $journee,
            'user' => $userp,
            'list' => $liste,
        ]);
    }

}
