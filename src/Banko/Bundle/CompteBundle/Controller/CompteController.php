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
        
        //Ici, on récupère les soldes courant et prévisionnel de chaque compte
        foreach ($liste_comptes as $compte)
        {
                $compte_courant = $em->getRepository('BankoCompteBundle:Compte')->getMontantCompteCourant($compte->getId());
                $solde_courant[$compte->getId()] = $compte->getSoldeInitial() + $compte_courant[0]['totalCreditTraite'] - $compte_courant[0]['totalDebitTraite'];

                $compte_previsionnel = $em->getRepository('BankoCompteBundle:Compte')->getMontantComptePrevisionnel($compte->getId());
                $solde_previsionnel[$compte->getId()] = $compte->getSoldeInitial() + $compte_previsionnel[0]['totalCredit'] - $compte_previsionnel[0]['totalDebit'];
        }
        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('BankoCompteBundle:Compte:index.html.twig', array(
          'liste_comptes' => $liste_comptes,
          'solde_courant' => $solde_courant,
          'solde_previsionnel' => $solde_previsionnel
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

      if($compte == null)
      {
          throw $this->createNotFoundException('Compte [id='.$id.'] inexistant.');
      }

      // On récupère la liste des mouvements par rapport au compte
      $liste_mouvements = $em->getRepository('BankoCompteBundle:Mouvement')->findByCompte($id);
      
      //On récupère le solde courant (initial + totalCreditTraite - totalDebitTraite)
      $compte_courant = $em->getRepository('BankoCompteBundle:Compte')->getMontantCompteCourant($id);
      $solde_courant = $compte->getSoldeInitial() + $compte_courant[0]['totalCreditTraite'] - $compte_courant[0]['totalDebitTraite'];
      
      //On récupère le solde courant (initial + totalCredit - totalDebit)
      $compte_previsionnel = $em->getRepository('BankoCompteBundle:Compte')->getMontantComptePrevisionnel($id);
      $solde_previsionnel = $compte->getSoldeInitial() + $compte_previsionnel[0]['totalCredit'] - $compte_previsionnel[0]['totalDebit'] ;

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('BankoCompteBundle:Compte:voir.html.twig', array(
        'compte' => $compte,
        'solde_courant' => $solde_courant,
        'solde_previsionnel' => $solde_previsionnel,
        'liste_mouvements' => $liste_mouvements,
      ));
    }
}