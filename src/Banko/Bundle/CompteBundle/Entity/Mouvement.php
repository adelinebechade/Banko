<?php

namespace Banko\Bundle\CompteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mouvement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Banko\Bundle\CompteBundle\Entity\MouvementRepository")
 */
class Mouvement
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Banko\Bundle\CompteBundle\Entity\Compte", inversedBy="mouvements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

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
     * @ORM\Column(name="traite", type="boolean")
     */
    private $traite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", nullable=true)
     */
    private $date;

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
     * Set traite
     *
     * @param boolean $traite
     * @return Mouvement
     */
    public function setTraite($traite)
    {
        $this->traite = $traite;
    
        return $this;
    }

    /**
     * Get traite
     *
     * @return boolean 
     */
    public function getTraite()
    {
        return $this->traite;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Mouvement
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
     * Set date
     *
     * @param \DateTime $date
     * @return Mouvement
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set credit
     *
     * @param string $credit
     * @return Mouvement
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
     * @return Mouvement
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

    /**
     * Set compte
     *
     * @param \Banko\Bundle\CompteBundle\Entity\Compte $compte
     * @return Mouvement
     */
    public function setCompte(\Banko\Bundle\CompteBundle\Entity\Compte $compte)
    {
        $this->compte = $compte;
    
        return $this;
    }

    /**
     * Get compte
     *
     * @return \Banko\Bundle\CompteBundle\Entity\Compte 
     */
    public function getCompte()
    {
        return $this->compte;
    }
}
