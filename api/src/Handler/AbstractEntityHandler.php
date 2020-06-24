<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\AbstractEntity;

abstract class AbstractEntityHandler
{
    public $em;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @access public
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    } // End function Constructor

    /**
     * handle
     *
     * @param mixed $entity
     * @param mixed $user
     * @access public
     * @return void
     */
    public function handle(
        $entity,
        $user
    ) {
        $entity->setUser($user);
        $this->em->persist($entity);
        $this->em->flush();
    } // End function handle
}
