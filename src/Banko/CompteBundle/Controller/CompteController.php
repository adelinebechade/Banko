<?php

namespace Banko\CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompteController extends Controller
{
    public function indexAction()
    {
        return $this->render('BankoCompteBundle:Compte:index.html.twig');
    }
}
