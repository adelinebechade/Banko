<?php
namespace Banko\Bundle\CompteBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
 
class MouvementAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'id'
    );
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('traite')
            ->add('libelle')
            ->add('date')
            ->add('credit')
            ->add('debit')
            ->add('compte')
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('traite')
            ->add('libelle')
            ->add('date')
            ->add('credit')
            ->add('debit')
            ->add('compte')
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('traite')
            ->addIdentifier('libelle')
            ->addIdentifier('date')
            ->add('credit')
            ->add('debit')
            ->add('compte')
        ;
    }
}