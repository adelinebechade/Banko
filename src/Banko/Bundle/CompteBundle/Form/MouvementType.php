<?php

namespace Banko\Bundle\CompteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MouvementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('traite', 'checkbox', array('required' => false, 'data' => true))
            ->add('libelle', 'text', array('attr' => array('placeholder' => 'Libellé')))
            ->add('date', 'text', array('data' => date("d/m/Y"), 'attr' => array('class' => 'form_date')))
            ->add('credit', 'text', array('attr' => array('placeholder' => 'Crédit', 'onkeyup' => 'noVirgule(this);')))
            ->add('debit', 'text', array('attr' => array('placeholder' => 'Débit', 'onkeyup' => 'noVirgule(this);')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Banko\Bundle\CompteBundle\Entity\Mouvement'
        ));
    }

    public function getName()
    {
        return 'banko_bundle_comptebundle_mouvementtype';
    }
}
