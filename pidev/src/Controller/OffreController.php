<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Form\UpdateOffreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="app_offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }

     /**
     * @Route("/addOffre", name="addOffre")
     */
    public function addoffre(Request $request): Response
    {
      
       $offre=new Offre();
       $form=$this->createForm(OffreType::class,$offre);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
           $filename=md5(uniqid()).'.'.$file->guessExtension();
           $file->move(
            $this->getParameter('Images_directory'),
            $filename
        );
         $em = $this->getDoctrine()->getManager();
           $offre->setImage($filename);
           $em->persist($offre);
           $em->flush();

           return $this->redirectToRoute('afficheOffre');
       }
       else
       return $this->render('offres/createOffre.html.twig',['f'=>$form->createView()]);

    }
     /**
     * @Route("/a", name="afficheOffre")
     */
    public function afficherOffre(): Response
    {
$offres=$this->getDoctrine()->getManager()->getRepository(Offre::class)->findAll();

        return $this->render('offres/index.html.twig',[ 
            'b'=>$offres
        ]);
    }
     /**
     * @Route("/suppoffre/{idoffre}", name="suppoffre")
     */
    public function supprimerEvent($idoffre): Response
    {
        $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($idoffre);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute('afficheOffre');
       
    }

      /**
     * @Route("/modifierOffre/{idoffre}", name="modifierOffre")
     */
    public function modifierOffre(Request $request,$idoffre): Response
    {
      
       $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($idoffre);
       $form=$this->createForm(UpdateOffreType::class,$offre);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('afficheOffre');
       }
       else
       return $this->render('Offres/UpdateOffre.html.twig',['f'=>$form->createView()]);

    }

    

            /**
     * @Route("/frontOffre", name="frontOffre")
     */
    public function afficherfront(): Response
    {
$Offres=$this->getDoctrine()->getManager()->getRepository(Offre::class)->findAll();

        return $this->render('offres/indexF.html.twig',[ 
            'b'=>$Offres
        ]);
    }

}
