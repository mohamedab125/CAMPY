<?php

namespace App\Controller;


use App\Entity\Evenement;
use App\Form\EventType;
use App\Form\UpdateEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Event\UpdateEvent;
use Symfony\Flex\Options;
use Dompdf\Dompdf; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\EvenementRepository;


class EvenementController extends AbstractController
{
    /**
     * @Route("/app_event", name="app_event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

     /**
     * @Route("/addEventt", name="addEventt")
     */
    public function addEvent(Request $request, \Swift_Mailer $mailer): Response
    {
      
       $evenement=new Evenement();
       $form=$this->createForm(EventType::class,$evenement);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
           $filename=md5(uniqid()).'.'.$file->guessExtension();
           $file->move(
            $this->getParameter('Images_directory'),
            $filename
            
        );
        
        $message =(new \Swift_Message('Evenement Ajouter'))
          ->setFrom('noreply.cyberark@gmail.com')
          ->setTo('louey.boujmil@esprit.tn')
          ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/registration.html.twig',
                
            ),
            'text/html'
          );
          $mailer->send($message);
         $em = $this->getDoctrine()->getManager();
           $evenement->setImage($filename);
           $em->persist($evenement);
           $em->flush();
    

           return $this->redirectToRoute('afficherEvent');
       }
       else
       return $this->render('event/createEvent.html.twig',['f'=>$form->createView()]);

    }

      /**
      * @Route("/" ,name="afficherEvent")
      */
    public function afficherEvenet(): Response
    {
$Evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->findAll();


        return $this->render('event/index.html.twig',[ 
            'b'=>$Evenement
        ]);
    }


         /**
     * @Route("/front", name="front")
     */
    public function afficherfront(): Response
    {
$Evenements=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->findAll();

        return $this->render('event/indexF.html.twig',[ 
            'b'=>$Evenements
        ]);
    }
     /**
     * @Route("/suppEvent/{id}", name="SuppEvent")
     */
    public function supprimerEvent(Evenement $Evenement): Response
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($Evenement);
        $em->flush();
        return $this->redirectToRoute('afficherEvent');
       
    }

     /**
     * @Route("/modifierEvent/{id}", name="modifierEvent")
     */
    public function modifierEvent(Request $request,$id): Response
    {
      
       $evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id);
       $form=$this->createForm(UpdateEventType::class,$evenement);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $file=$evenement->getImageFile();
        if($file)
        {
        $filename=md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move(
                $this->getParameter('images_directory'),
                $filename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
        $evenement->setImage($filename);
        }
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('afficherEvent');
       }
       else
       return $this->render('event/updateEvent.html.twig',['f'=>$form->createView()]);

    }

     /**
     * @Route("/pdf/{id}", name="pdf" ,  methods={"GET"})
     */
    public function pdf($id,EvenementRepository $repository  )
    {
        $reponse = $this->getDoctrine()->getRepository(Evenement::class)->findOneBy( ['id' => $id]);

      #  $Evenement = $repository->find($id);


        $pdfOptions = new Options();
        


        $pdfOptions->get('defaultFont', 'Arial');
        $dompdf = new Dompdf( $pdfOptions);
        $html="<style>
.clearfix:after {
  content: \"\";
  display: table;
  clear: both;
}
a {
  color: #001028;
  text-decoration: none;
}
body {
  font-family: Junge;
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-size: 14px; 
}
.arrow {
  margin-bottom: 4px;
}
.arrow.back {
  text-align: right;
}
.inner-arrow {
  padding-right: 10px;
  height: 30px;
  display: inline-block;
  background-color: rgb(233, 125, 49);
  text-align: center;
  line-height: 30px;
  vertical-align: middle;
}
.arrow.back .inner-arrow {
  background-color: rgb(233, 217, 49);
  padding-right: 0;
  padding-left: 10px;
}
.arrow:before,
.arrow:after {
  content:'';
  display: inline-block;
  width: 0; height: 0;
  border: 15px solid transparent;
  vertical-align: middle;
}
.arrow:before {
  border-top-color: rgb(233, 125, 49);
  border-bottom-color: rgb(233, 125, 49);
  border-right-color: rgb(233, 125, 49);
}
.arrow.back:before {
  border-top-color: transparent;
  border-bottom-color: transparent;
  border-right-color: rgb(233, 217, 49);
  border-left-color: transparent;
}
.arrow:after {
  border-left-color: rgb(233, 125, 49);
}
.arrow.back:after {
  border-left-color: rgb(233, 217, 49);
  border-top-color: rgb(233, 217, 49);
  border-bottom-color: rgb(233, 217, 49);
  border-right-color: transparent;
}
.arrow span { 
  display: inline-block;
  width: 80px; 
  margin-right: 20px;
  text-align: right; 
}
.arrow.back span { 
  margin-right: 0;
  margin-left: 20px;
  text-align: left; 
}
h1 {
  color: #5D6975;
  font-family: Junge;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  border-top: 1px solid #5D6975;
  border-bottom: 1px solid #5D6975;
  margin: 0 0 2em 0;
}
h1 small { 
  font-size: 0.45em;
  line-height: 1.5em;
  float: left;
} 
h1 small:last-child { 
  float: right;
} 
#project { 
  float: left; 
}
#company { 
  float: right; 
}
table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 30px;
}
table th,
table td {
  text-align: center;
}
table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}
table .service,
table .desc {
  text-align: left;
}
table td {
  padding: 20px;
  text-align: right;
}
table td.service,
table td.desc {
  vertical-align: top;
}
table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}
table td.sub {
  border-top: 1px solid #C1CED9;
}
table td.grand {
  border-top: 1px solid #5D6975;
}
table tr:nth-child(2n-1) td {
  background: #EEEEEE;
}
table tr:last-child td {
  background: #DDDDDD;
}
#details {
  margin-bottom: 30px;
}
footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}</style>
<h1>Evenement</h1>
 <!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <title>EVENEMENT</title>
    <link rel=\"stylesheet\" href=\"style.css\" media=\"all\" />
  </head>
  <body>
    <main>
      <h2  class=\"clearfix\"><small><span>Nom</span>
      <br />".$reponse->getNom()."
      <table>
        <thead>
        
          <tr>
            <th class=\"clearfix\">Nombre De places</th>
          </tr>
        </thead><tbody>
        <tr><td  class=\"service\">".$reponse-> getNbreDeplaces()."</td>
        </tr>

        <tr>
        <th class=\"clearfix\">type</th>
      </tr>
    </thead><tbody>
    <tr><td  class=\"service\">".$reponse-> getType()."</td>
    </tr>

    <tr>
    <th class=\"clearfix\">prix</th>
  </tr>
</thead><tbody>
<tr><td  class=\"service\">".$reponse-> getPrix()."</td>
</tr>

<tr>
<th class=\"clearfix\">date</th>
</tr>
</thead><tbody>
<tr><td  class=\"service\">".$reponse-> getDate()->format('d/m/Y')."</td>
</tr>
        
        
 </tbody>
      </table>
       </br></br></br></br></br>
     
  
     
    </main>
    
  </body>
</html>";




        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
          $dompdf->stream();
        // Output the generated PDF to Browser (force download)
        $dompdf->stream($reponse->getId(), [
            "Attachment" => true
        ]);
        return $this->renderView('event/index.html.twig', [
            'Evenements' => $reponse
        ]);
    }





    /**
     * @Route("/participer/{id}", name="participer")
     */
    public function participer(Evenement $Evenement): Response
    {
      
        $em=$this->getDoctrine()->getManager();
        $Evenement->setNbreDeplaces($Evenement->getNbreDeplaces()-1);
        $em->flush();
        return $this->redirectToRoute('front');
    }
/**
     * @Route("/stats", name="stats")
     */
    public function statistiques(EvenementRepository  $evRepository){
      // On va chercher toutes les catégories

      $evenement = $evRepository->countByDate();
      $dates = [];
      $produitCount = [];
      $categColor = [];
      foreach($evenement as $ev){
          $dates[] = $ev['date'];
          $produitCount[] = $ev['count'];
      }


      return $this->render('admin/stats.html.twig', [
          'dates' => json_encode($dates),
          'produitCount' => json_encode($produitCount),
      ]);


  }

   
     
}








    
   




