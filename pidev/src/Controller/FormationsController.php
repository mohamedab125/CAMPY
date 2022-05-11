<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationajouteType;
use App\Form\FormationmodifierType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations", name="formations")
     */
    public function index(): Response
    {
        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }
    
      /**
     * @Route("/addformation", name="addformation")
     */
    public function addformation(Request $request,MailerInterface $mailer): Response
    {
     
        $formation = new Formation();
        $form = $this->createForm(FormationajouteType::class,$formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $email=(new Email())
                ->from('noreply.cinemart@gmail.com')
                ->to('mohamed.abdelkebir1@esprit.tn')
                ->subject('votre formation est ajouter avec succes')
                ->text('llalaa')
                ->html('<p>votre formation est ajouter avec succes</p>');
            $mailer->send($email);    
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('displayformation');
        }
        else
        return $this->render('formations/ajouterformation.html.twig',['f'=>$form->createView()]);
    }

      /**
     * @Route("/display", name="displayformation")
     */
    public function afficher(): Response
    {
        $formation= $this->getDoctrine()->getManager()->getRepository(Formation::class)->findAll();
        return $this->render('formations/index.html.twig', [
            'b'=>$formation
        ]);
    }



      /**
     * @Route("/displayfrontformation", name="displayfrontformation")
     */
    public function displayfrontformation(): Response
    {
        $formation= $this->getDoctrine()->getManager()->getRepository(Formation::class)->findAll();
        return $this->render('formations/frontformation.html.twig', [
            'b'=>$formation
        ]);
    }

     /**
     * @Route("/deleteformation/{id}", name="deleteformation")
     */
    public function supprimerformation(Formation $formation): Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();
        return $this->redirectToRoute('displayformation');
   
    }


    
      /**
     * @Route("/modifierformation/{id}", name="modifierformation")
     */
    public function modifierformation(Request $request,$id): Response
    {
     
        $formation = $this->getDoctrine()->getManager()->getRepository(formation::class)->find($id);
        $form = $this->createForm(FormationmodifierType::class,$formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('displayformation');
        }
        else
        return $this->render('formations/modifierformation.html.twig',['f'=>$form->createView()]);
    }

}

