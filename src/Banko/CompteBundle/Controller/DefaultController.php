<?php

namespace Banko\CompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BankoCompteBundle:Default:index.html.twig', array('name' => $name));
    }
}
