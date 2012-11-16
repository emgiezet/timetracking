<?php

namespace App\GeneralBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * App\GeneralBundle\Entity\User
 * 
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    
    /**
     * @var integer $id
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var ArrayCollection $groups
     * 
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="user_to_user_group",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)}
     * )
     */
    protected $groups;
    
    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }
}