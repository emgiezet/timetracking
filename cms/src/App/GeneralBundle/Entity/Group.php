<?php

namespace App\GeneralBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\GeneralBundle\Entity\Group
 * 
 * @ORM\Table(name="user_group")
 * @ORM\Entity
 */
class Group extends BaseGroup
{
    
    /**
     * @var integer $id
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;
}