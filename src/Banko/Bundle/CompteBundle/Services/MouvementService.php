<?php

namespace Banko\Bundle\CompteBundle\Services;

use Doctrine\ORM\EntityManager;
use Banko\Bundle\CompteBundle\Entity\Compte;
use Banko\Bundle\CompteBundle\Entity\Mouvement;
use Banko\Bundle\CompteBundle\Entity\MouvementAutomatique;
use Banko\Bundle\CompteBundle\Entity\MouvementRepository;

class MouvementService 
{
    /**
     *
     * @var EntityManager 
     */
    protected $em;

    protected $controller;

    public function initController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function create($mouvement, $compte)
    {
        //  $mouvement->setDate(\DateTime::createFromFormat('d/m/Y',$mouvement->getDate()));
        $mouvement->setCompte($compte);

        $this->save($mouvement);
    }

    public function ajoutPrelevementAutomatique($compte)
    {
        //Récupération des mouvements automatique actifs sur le compte
        $mouvement_automatique = $this->em->getRepository('BankoCompteBundle:MouvementAutomatique')->getMouvementAutomatiqueActifCompte($compte->getId());

        //S'il existe des mouvements automatiques actifs sur le compte
        if(count($mouvement_automatique)!= 0)
        {
            foreach ($mouvement_automatique as $mvt_auto)
            {
                $mouvement = new Mouvement();

                //Si on est à moins de 10 jours du mois suivant, on ajoute les prochains prelevements automatiques
                if(date('t',mktime(0, 0, 0, date('m'), 1, date('Y'))) - date('d') <= 3)
                {
                    //Si on est au mois de décembre on prend le mois de janvier sinon m+1
                    if(date('m') == 12)
                    {
                        $mois_suivant = "01";
                    }
                    else 
                    {
                        $mois_suivant = date('m')+1;
                    }

                    //Si le mouvement automatique n'est pas ajouté au compte pour le mois suivant, on l'ajoute
                    if ($this->em->getRepository('BankoCompteBundle:Mouvement')->getMouvementCompte($compte->getId(), $mvt_auto['libelle'], $mvt_auto['numeroJour'], $mvt_auto['credit'], $mvt_auto['debit'], $mois_suivant, true) == false)
                    {
                        $mouvement->setCompte($compte);
                        $mouvement->setTraite(0);
                        $mouvement->setLibelle($mvt_auto['libelle']);
                        //Si on est au mois de décembre on prend l'année suivante et le mois de janvier pour la date du prélevement auto
                        if(date('m') == 12)
                        {
                                $mouvement->setDate(new \Datetime(date('Y')+1).'-'.('01').$mvt_auto['numeroJour']);
                        }
                        else 
                        {
                                $mouvement->setDate(new \DateTime(date('Y').'-'.(date('m')+1).'-'.$mvt_auto['numeroJour']));
                        }
                        $mouvement->setCredit($mvt_auto['credit']);
                        $mouvement->setDebit($mvt_auto['debit']);

                        $this->save($mouvement);
                    }
                }
                else
                {
                    //Si le mouvement automatique n'est pas ajouté au compte pour le mois en cours, on l'ajoute
                    if ($this->em->getRepository('BankoCompteBundle:Mouvement')->getMouvementCompte($compte->getId(), $mvt_auto['libelle'], $mvt_auto['numeroJour'], $mvt_auto['credit'], $mvt_auto['debit'], date('m'), false) == false)
                    {
                        $mouvement->setCompte($compte);
                        $mouvement->setTraite(0);
                        $mouvement->setLibelle($mvt_auto['libelle']);
                        $mouvement->setDate(new \DateTime(date('Y').'-'.date('m').'-'.$mvt_auto['numeroJour']));
                        $mouvement->setCredit($mvt_auto['credit']);
                        $mouvement->setDebit($mvt_auto['debit']);

                        $this->save($mouvement);
                    }
                }
            } 
	}
    }

    private function save($mouvement)
    {
        $this->em->persist($mouvement);
        $this->em->flush();
    }
}
?>
