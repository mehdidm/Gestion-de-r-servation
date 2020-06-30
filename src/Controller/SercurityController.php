<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Entity\Search;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SercurityController extends AbstractController
{
    /**
     * @Route("/sercurity", name="sercurity")
     */
    public function index()
    {
        return $this->render('sercurity/index.html.twig', [
            'controller_name' => 'SercurityController',
        ]);
    }
    
      /**
     * @Route("/connexion",name="login")
     */
    public function login(AuthenticationUtils  $authenticationUtils)
    {
      // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();
    
      return $this->render('sercurity/login.html.twig',['lastUsername'=>$lastUsername,'error' => $error]);
    }

    
/**
 * @Route("/deconnexion",name="security_logout")
 */
public function logout()
{ }
}
