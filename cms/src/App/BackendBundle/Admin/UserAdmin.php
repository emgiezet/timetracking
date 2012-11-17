<?php

namespace App\BackendBundle\Admin;

use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

class UserAdmin extends Admin
{
    
    protected $baseRoutePattern = 'users';
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper->add("email");
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add("firstname")
                ->add("lastname")
                ->add("email")
            ->end()
            ->with('Permissions')
                ->add("enabled", null, array("required" => false, "label" => "Active"))
                ->add("groups", null, array("expanded" => false, "multiple" => true, "property" => "name"))
            ->end()
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier("name")
            ->add("email")
            ->add("groups", null, array("label" => "Roles"))
            ->add("enabled", null, array("label" => "Status", "template" => "AppBackendBundle:CRUD:list_status.html.twig"))
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
        $datagridMapper
            ->add("email")
            ->add("enabled");
    }
    
}