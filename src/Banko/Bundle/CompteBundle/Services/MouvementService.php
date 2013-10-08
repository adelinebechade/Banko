<?php

namespace Banko\Bundle\CompteBundle\Services;
use Doctrine\ORM\EntityManager;

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
        $mouvement->setDate(\DateTime::createFromFormat('d/m/Y',$mouvement->getDate()));
        $mouvement->setCompte($compte);

        $this->save($mouvement);
    }

    private function save($mouvement)
    {
        $this->em->persist($mouvement);
        $this->em->flush();
    }
}
?>
