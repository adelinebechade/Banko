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
            ->add('traite', 'checkbox', array('required' => false))
            ->add('libelle')
            ->add('date', 'text', array('attr' => array('class' => 'form_date')))
            ->add('credit')
            ->add('debit')
            ->add('compte','entity', array(
            'class' => 'Banko\Bundle\CompteBundle\Entity\Compte',
            'property' => 'nom',
            'multiple' => false,
            'required' => true,
            'empty_value' => ''
            ));
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
