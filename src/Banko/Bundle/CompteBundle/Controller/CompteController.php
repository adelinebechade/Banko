<?php

namespace Banko\Bundle\CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CompteController extends Controller
{
    /**
     * @Route("/compte")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('BankoCompteBundle:Compte:index.html.twig');
    }
}