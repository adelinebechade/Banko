<?php

namespace Banko\Bundle\CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SaadTazi\GChartBundle\DataTable;
use SaadTazi\GChartBundle\Chart\PieChart;

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
                $solde_courant[$compte->getId()] = round($compte->getSoldeInitial() + $compte_courant[0]['totalCreditTraite'] - $compte_courant[0]['totalDebitTraite'], 2);

                $compte_previsionnel = $em->getRepository('BankoCompteBundle:Compte')->getMontantComptePrevisionnel($compte->getId());
                $solde_previsionnel[$compte->getId()] = round($compte->getSoldeInitial() + $compte_previsionnel[0]['totalCredit'] - $compte_previsionnel[0]['totalDebit'], 2);
        }
        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('BankoCompteBundle:Compte:index.html.twig', array(
          'liste_comptes' => $liste_comptes,
          'solde_courant' => $solde_courant,
          'solde_previsionnel' => $solde_previsionnel
        ));
    }
    
    /**
     * @Route("/compte/voir/{id}/{page}", name="banko_voir", requirements={"id" = "\d+"})
     * @Template()
     */
    public function voirAction($id, $page)
    {
      $em = $this->getDoctrine()->getManager();
      $compte = $em->getRepository('BankoCompteBundle:Compte')->find($id);

      if($compte == null)
      {
          throw $this->createNotFoundException('Compte [id='.$id.'] inexistant.');
      }

      //Appel du traitement de l'ajout des prelevements automatiques du mois en cours pour le compte à afficher
      $this->get("MouvementService")->ajoutPrelevementAutomatique($compte);

      // On récupère la liste des mouvements par rapport au compte
      //$liste_mouvements = $em->getRepository('BankoCompteBundle:Mouvement')->findByCompte($id);
      $liste_mouvements = $em->getRepository('BankoCompteBundle:Mouvement')->getMouvementsCompte($id, 20, $page);

      //On récupère le solde courant (initial + totalCreditTraite - totalDebitTraite)
      $compte_courant = $em->getRepository('BankoCompteBundle:Compte')->getMontantCompteCourant($id);
      $solde_courant = round($compte->getSoldeInitial() + $compte_courant[0]['totalCreditTraite'] - $compte_courant[0]['totalDebitTraite'], 2);

      //On récupère le solde courant (initial + totalCredit - totalDebit)
      $compte_previsionnel = $em->getRepository('BankoCompteBundle:Compte')->getMontantComptePrevisionnel($id);
      $solde_previsionnel = round($compte->getSoldeInitial() + $compte_previsionnel[0]['totalCredit'] - $compte_previsionnel[0]['totalDebit'], 2) ;

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('BankoCompteBundle:Compte:voir.html.twig', array(
        'compte' => $compte,
        'solde_courant' => $solde_courant,
        'solde_previsionnel' => $solde_previsionnel,
        'liste_mouvements' => $liste_mouvements,
        'page'        => $page,
        'nombrePage' => ceil(count($liste_mouvements)/20),
      ));
    }
    
    /**
     * @Route("/compte/stats", name="stats")
     * @Template()
     */
    public function statsAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Ici, on récupérera la liste des comptes, puis on la passera au template
        $liste_comptes = $em->getRepository('BankoCompteBundle:Compte')->findAll();

        /*
         * dataTable for Bar Chart for example (3 columns)
         */
        $dataTable2 = new DataTable\DataTable();
        $dataTable2->addColumn('id1', 'label 1', 'string');
        $dataTable2->addColumnObject(new DataTable\DataColumn('id2', 'Courant', 'number'));
        $dataTable2->addColumnObject(new DataTable\DataColumn('id3', 'Prévisionnel', 'number'));
        
        //Ici, on récupère les soldes courant et prévisionnel de chaque compte
        foreach ($liste_comptes as $compte)
        {
            //Récupération du nom du compte
            $nomCompte = $compte->getNom();

            //Récupération du montant courant du compte
            $compte_courant = $em->getRepository('BankoCompteBundle:Compte')->getMontantCompteCourant($compte->getId());
            $soldeCourant = $compte->getSoldeInitial() + $compte_courant[0]['totalCreditTraite'] - $compte_courant[0]['totalDebitTraite'];

            //Récupération du montant prévisionnel du compte
            $compte_previsionnel = $em->getRepository('BankoCompteBundle:Compte')->getMontantComptePrevisionnel($compte->getId());
            $soldePrevisionnel = $compte->getSoldeInitial() + $compte_previsionnel[0]['totalCredit'] - $compte_previsionnel[0]['totalDebit'];
            
            $dataTable2->addRow(array($nomCompte, $soldeCourant, $soldePrevisionnel));
        }

        return $this->render('BankoCompteBundle:Compte:stats.html.twig', array(
                        'dataTable2' => $dataTable2->toArray()));
    }
}