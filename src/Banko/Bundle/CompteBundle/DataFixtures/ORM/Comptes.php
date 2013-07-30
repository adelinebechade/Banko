<?php
namespace Banko\Bundle\CompteBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Banko\Bundle\CompteBundle\Entity\Compte;
 
class Comptes implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compte à ajouter
    $noms = array('AB', 'AB - L', 'PR', 'PR - L', 'LR - L', 'CC');
 
    foreach($noms as $i => $nom)
    {
      // On crée le comtpe
      $liste_comptes[$i] = new Compte();
      $liste_comptes[$i]->setNom($nom);
      $liste_comptes[$i]->setSoldeInitial('0');
      $liste_comptes[$i]->setOrdre($i);
 
      // On la persiste
      $manager->persist($liste_comptes[$i]);
    }
 
    // On déclenche l'enregistrement
    $manager->flush();
  }
}
?>
