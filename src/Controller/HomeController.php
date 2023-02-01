<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Journee;
use App\Entity\User;
use App\Entity\Participants;
use Doctrine\Persistence\ManagerRegistry;
class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $list = $doctrine->getRepository(Journee::class)->findAll();
        $user = $this->getUser();
        $user_id = $user->getId();
        $in_list = array();
        foreach ($list as $key => $value) {
            $this_id = $list[$key]->getId();
            $is_in = $doctrine->getRepository(Participants::class)->findBy(array('journee' => $list[$key]) );
            $ok = 0;
            foreach ($is_in as $key2 => $value2) {
                if ($is_in[$key2]->getId()== $user_id) { 
                    $ok = 1;
                }
            }
            $in_list[$this_id] = $ok;

        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list' => $list,
            'user' => $user,
            'in_list' => $in_list,
        ]);
    }

}
