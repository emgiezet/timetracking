<?php

namespace App\BackendBundle\Admin;

use App\GeneralBundle\Entity\User;
use Sonata\AdminBundle\Validator\ErrorElement;
use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\Admin;

/**
 * Admin class for managing users
 * 
 *
 */
class UserAdmin extends Admin
{
    
    /**
     * @var UserManagerInterface $userManager
     */
    protected $userManager;
    
    /**
     * @var string $baseRoutePattern
     */
    protected $baseRoutePattern = 'users';
    
    /**
     * Set userManager
     *
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * Get userManager
     *
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->saveUser($user);
    }
    
    /**
     * {@inheritdoc}
     */
    public function prePersist($user)
    {
        $this->saveUser($user);
    }
    
    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('email')
                ->assertNotBlank()
                ->assertEmail()
            ->end()
        ;
    }
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with("General")
                ->add("name")
                ->add("email")
            ->end()
            ->with('Permissions')
                ->add("enabled", null, array("label" => "Status"))
                ->add("groups")
            ->end()
         ;
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
                'label' => 'Actions',
                'actions' => array(
                    'view' => array('template' => 'AppBackendBundle:CRUD:list__action_view.html.twig'),
                    'edit' => array('template' => 'AppBackendBundle:CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'AppBackendBundle:CRUD:list__action_delete.html.twig'),
                )
            ));
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add("email", null, array("label" => "Email"))
            ->add("name", "doctrine_orm_callback", array(
                'callback' => function($queryBuilder, $alias, $field, $value) {
                    if (!$value || $value['value'] == "") {
                        return;
                    }
                    $queryBuilder->orWhere($alias.'.firstname LIKE :name');
                    $queryBuilder->orWhere($alias.'.lastname LIKE :name');
                    $queryBuilder->setParameter('name', '%'.$value['value'].'%');
                    return true;
                }))
            ->add("enabled", null, array("label" => "Enabled"))
        ;
    }
    
    /**
     * Save user
     * 
     * @param User $user
     */
    private function saveUser(User $user) 
    {
        if (!$user->getId()) {
            $user->setPlainPassword($this->generateRandomPassword());
        }
        $user->setUsername($user->getEmail());
        $this->getUserManager()->updateUser($user);
        //TODO send email
    }
    
    /**
     * Generate random user password
     * 
     * @return string
     */
    private function generateRandomPassword()
    {
        return substr(md5(time().rand(1, 10000)), 7, 8); 
    }
    
}