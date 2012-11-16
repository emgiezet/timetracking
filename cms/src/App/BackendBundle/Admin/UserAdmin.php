<?php

namespace App\BackendBundle\Admin;

use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class UserAdmin extends Admin
{
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper->add("email");
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add("email")
            ->end()
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add("email")
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
        ));
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add("email");
    }
    
}