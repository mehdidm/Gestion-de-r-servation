<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClientRepository;



use App\Form\EditUserType;






/**
 * @Route("/admin", name="admin_")
*/

class AdminController extends AbstractController
{   
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
     * @Route("/clients/modifier/{id}", name="modifier_client")
     */
    public function editUser(Request $request, Client $client, EntityManagerInterface  $em) {
       
        $form = $this->createForm(EditUserType::class,$client);
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $em->flush();
  
          return $this->redirectToRoute('admin_clients');
        }
  
        return $this->render('admin/editUser.html.twig', ['formUser' => $form->createView()]);
      }
     /**
     * @Route("/clients", name="clients")
     */
    public function usersList(ClientRepository $client) {
        return $this->render("admin/clients.html.twig",[
            'clients' => $client->findAll()
        ]);
    }

   
}
