<?php

namespace Banko\Bundle\CompteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompteMouvementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mouvements', 'collection', array('type' => new MouvementType(), 
                                                        'allow_add' => true,
                                                        'allow_delete' => true,
                                                        'prototype' => true,
                                                        'by_reference' => false)
        );
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
