<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * entityManager 
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     * @access private
     */
    private $entityManager;

    /**
     * userPasswordEncoder 
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     * @access private
     */
    private $userPasswordEncoder;

    /**
     * decorated 
     *
     * @var \ApiPlatform\Core\DataPersister\DataPersisterInterface
     * @access private
     */
    private $decorated;

    public function __construct(
      EntityManagerInterface $entityManager,
      UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        $encodedPassword = $this->userPasswordEncoder->encodePassword($data, $data->getPassword());
        $data->setPassword($encodedPassword);

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
