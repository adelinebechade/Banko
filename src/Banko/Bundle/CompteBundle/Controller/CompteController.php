<?php

namespace Banko\Bundle\CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CompteController extends Controller
{
    /**
     * @Route("/compte", name="banko_home")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        // Ici, on récupérera la liste des comptes, puis on la passera au template
        $liste_comptes = $em->getRepository('BankoCompteBundle:Compte')->findAll();

        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('BankoCompteBundle:Compte:index.html.twig', array(
          'liste_comptes' => $liste_comptes
        ));
    }
    
    /**
     * @Route("/compte/voir/{id}", name="banko_voir", requirements={"id" = "\d+"})
     * @Template()
     */
    public function voirAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $compte = $em->getRepository('BankoCompteBundle:Compte')->find($id);

      /*$article = $this->getDoctrine()
                  ->getManager()
                  ->find('SdzBlogBundle:Article', $id);*/

      if($compte == null)
      {
          throw $this->createNotFoundException('Compte [id='.$id.'] inexistant.');
      }


      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('BankoCompteBundle:Compte:voir.html.twig', array(
        'compte' => $compte
      ));
    }
}