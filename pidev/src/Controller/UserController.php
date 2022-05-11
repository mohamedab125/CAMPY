<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserupdateType;
use App\Repository\UserRepository as RepositoryUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserController extends AbstractController 
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/user", name="displayuser")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


      /**
     * @Route("/adduser", name="adduser")
     */
    public function adduser(Request $request): Response
    {
     
        $user = new User();
       
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('displayusers');
        }
        else
        return $this->render('user/createuser.html.twig',['f'=>$form->createView()]);
    }

      /**
     * @Route("/", name="displayusers")
     */
    public function afficherusers(): Response
    {
        $users= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'b'=>$users
        ]);
    }

          /**
     * @Route("/displayprofil/{id}", name="displayprofil")
     */
    public function displayuser(Request $request,$id): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        
        return $this->render('user/frontprofil.html.twig', [
            'b'=>$user
        ]);
    }

     /**
     * @Route("/deleteuser/{id}", name="deleteuser")
     */
    public function supprimeruser(user $user): Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('displayusers');
   
    }


    
      /**
     * @Route("/modifieruser/{id}", name="modifieruser")
     */
    public function modifieruser(Request $request,$id): Response
    {
     
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserupdateType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('displayusers');
        }
        else
        return $this->render('user/modifieruser.html.twig',['f'=>$form->createView()]);
    }

     /**
     * @Route("/bann/{id}", name="bann")
     */
    public function bann(Request $request,$id): Response
    {
     
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
            if($user->getrole()=="banned")
            {
                $user->setrole("ROLE_USER");
            }
            else
            $user->setrole("banned");
    
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('displayusers');

       
    }

     /**
     * @Route("/resetpwd", name="app_resetpwd")
     */
    public function index2(): Response
    {
        return $this->render('reset_password/rstpwd.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

}
