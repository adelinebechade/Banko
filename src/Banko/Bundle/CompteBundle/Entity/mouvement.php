<?php

namespace Banko\Bundle\CompteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mouvement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Banko\Bundle\CompteBundle\Entity\mouvementRepository")
 */
class mouvement
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
     * @ORM\Column(name="traite", type="boolean")
     */
    private $traite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
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
     * @return mouvement
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
     * @return mouvement
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
     * @return mouvement
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
     * @return mouvement
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
     * @return mouvement
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
