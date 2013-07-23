<?php

namespace Banko\Bundle\CompteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mouvementAutomatique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Banko\Bundle\CompteBundle\Entity\mouvementAutomatiqueRepository")
 */
class mouvementAutomatique
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
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroJour", type="smallint")
     */
    private $numeroJour;

    /**
     * @var string
     *
     * @ORM\Column(name="credit", type="string", length=255)
     */
    private $credit;

    /**
     * @var string
     *
     * @ORM\Column(name="debit", type="string", length=255)
     */
    private $debit;


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
     * Set actif
     *
     * @param boolean $actif
     * @return mouvementAutomatique
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return mouvementAutomatique
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set numeroJour
     *
     * @param integer $numeroJour
     * @return mouvementAutomatique
     */
    public function setNumeroJour($numeroJour)
    {
        $this->numeroJour = $numeroJour;
    
        return $this;
    }

    /**
     * Get numeroJour
     *
     * @return integer 
     */
    public function getNumeroJour()
    {
        return $this->numeroJour;
    }

    /**
     * Set credit
     *
     * @param string $credit
     * @return mouvementAutomatique
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    
        return $this;
    }

    /**
     * Get credit
     *
     * @return string 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set debit
     *
     * @param string $debit
     * @return mouvementAutomatique
     */
    public function setDebit($debit)
    {
        $this->debit = $debit;
    
        return $this;
    }

    /**
     * Get debit
     *
     * @return string 
     */
    public function getDebit()
    {
        return $this->debit;
    }
}
