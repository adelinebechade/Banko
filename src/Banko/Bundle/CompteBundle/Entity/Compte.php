<?php

namespace Banko\Bundle\CompteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Compte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Banko\Bundle\CompteBundle\Entity\CompteRepository")
 */
class Compte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="soldeInitial", type="string", length=255)
     */
    private $soldeInitial;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="bigint")
     */
    private $ordre;

    protected $mouvements;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Compte
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set soldeInitial
     *
     * @param string $soldeInitial
     * @return Compte
     */
    public function setSoldeInitial($soldeInitial)
    {
        $this->soldeInitial = $soldeInitial;
    
        return $this;
    }

    /**
     * Get soldeInitial
     *
     * @return string 
     */
    public function getSoldeInitial()
    {
        return $this->soldeInitial;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return Compte
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Add mouvements
     *
     * @param \Banko\Bundle\CompteBundle\Entity\Mouvement $mouvements
     * @return Compte
     */
    public function addMouvement(\Banko\Bundle\CompteBundle\Entity\Mouvement $mouvements)
    {
        $this->mouvements[] = $mouvements;
    
        return $this;
    }

    /**
     * Remove mouvements
     *
     * @param \Banko\Bundle\CompteBundle\Entity\Mouvement $mouvements
     */
    public function removeMouvement(\Banko\Bundle\CompteBundle\Entity\Mouvement $mouvements)
    {
        $this->mouvements->removeElement($mouvements);
    }

    public function getMouvements()
    {
        return $this->mouvements;
    }

    public function setMouvements(ArrayCollection $mouvements)
    {
        $this->mouvements = $mouvements;
    }
}