<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       $user = $this->getUser();
       if($user->getRole()=="ROLE_ADMIN")
       {
        return $this->redirectToRoute('displayusers');
       }
      else if ($user->getRole()=="ROLE_USER")
      {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->find($user->getid());
        
        return $this->render('user/frontprofil.html.twig', [
            'b'=>$users
        ]);
      }
      else
      {
        return $this->redirectToRoute('app_logout');
      }
     

    }


     /**
     * @Route("/home/delete", name="delete")
     */
    public function delete()
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'est pas un admin');
        return $this->render('security/user_home.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        $error = "";
        // last username entered by the user
        $lastUsername = "";

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);  
          
    }



}