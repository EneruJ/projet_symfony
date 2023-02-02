<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Journee;
use App\Entity\User;
use App\Entity\UserJournee;
use Doctrine\Persistence\ManagerRegistry;
class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $list = $doctrine->getRepository(Journee::class)->findAll();
        $user = $this->getUser();
        $in_list = array();
        if ($user) {
            $user_id = $user->getId();
            
            foreach ($list as $key => $value) {
                $this_id = $list[$key]->getId();
                $is_in = $doctrine->getRepository(UserJournee::class)->findBy(array('journee' => $list[$key]));
                if ($is_in) {
                    $ok = 0;
                    foreach ($is_in as $key2 => $value2) {
                        if ($is_in[$key2]->getUser() == $user) { 
                            $ok = 1;
                        }
                    } 
                    $in_list[$this_id] = $ok;
                }
                
            }
        }
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list' => $list,
            'user' => $user,
            'in_list' => $in_list,
        ]);
    }

    public function mesjours(ManagerRegistry $doctrine): Response
    {
        $list = $doctrine->getRepository(Journee::class)->findAll();
        $user = $this->getUser();
        $in_list = array();
        if ($user) {
            $user_id = $user->getId();
            
            foreach ($list as $key => $value) {
                $this_id = $list[$key]->getId();
                $is_in = $doctrine->getRepository(UserJournee::class)->findBy(array('journee' => $list[$key]));
                if ($is_in) {
                    $ok = 0;
                    foreach ($is_in as $key2 => $value2) {
                        if ($is_in[$key2]->getUser() == $user) { 
                            $ok = 1;
                        }
                    }
                    $in_list[$this_id] = $ok;
                }
                
            }
        }
        
        return $this->render('journee/mesjours.twig', [
            'controller_name' => 'HomeController',
            'list' => $list,
            'user' => $user,
            'in_list' => $in_list,
        ]);
    }

}
