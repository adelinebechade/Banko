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
            ->add('libelle', 'text', array('data' => ''))
            ->add('date', 'text', array('data' => date("d/m/Y"), 'attr' => array('class' => 'form_date')))
            ->add('credit', 'text', array('data' => '0'))
            ->add('debit', 'text', array('data' => '0'))
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
