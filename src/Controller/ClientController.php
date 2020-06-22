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
/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
   /**
     * @Route("/", name="client_index")
     */
    public function index(Request $request): Response
    {
    $Search = new Search();
    $form = $this->createForm(SearchType::class,$Search);
    $form->handleRequest($request);
   //initialement le tableau des articles est vide, 
   //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
   $clients= $this->getDoctrine()->getRepository(Client::class)->findAll();
    
   if($form->isSubmitted() && $form->isValid()) {
   //on récupère le nom d'article tapé dans le formulaire
    $nom = $Search->getNom();   
    if ($nom!="") 
      //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
      $clients= $this->getDoctrine()->getRepository(Client::class)->findBy(['nom' => $nom] );
    else   
      //si si aucun nom n'est fourni on affiche tous les articles
      $clients= $this->getDoctrine()->getRepository(Client::class)->findAll();
   }
    return  $this->render('client/index.html.twig',[ 'form' =>$form->createView(), 'clients' => $clients]);  
  }
     /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
 /* public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
*/
/**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em, 
    UserPasswordEncoderInterface $encoder)
{
    $client = new Client();
    $form  = $this->createForm(ClientType::class, $client);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
        $hash = $encoder->encodePassword($client,$client->getPassword());
        $client->setPassword($hash);
    
    //l'objet $em sera affecté automatiquement grâce à l'injection des dépendances de symfony 4  
       $em->persist($client);
       $em->flush();  
       return $this->redirectToRoute('client_index');
    }
   return $this->render('client/new.html.twig', 
                       ['form' =>$form->createView()]);
}
  
    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
    

    /**
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }
    


}
