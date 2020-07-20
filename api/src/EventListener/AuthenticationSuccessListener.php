<?php

declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationSuccessListener
{
  /**
   * @param AuthenticationSuccessEvent $event
   */
  public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
  {
      $data = $event->getData();
      $user = $event->getUser();

      if (!$user instanceof UserInterface) {
          return;
      }



      $event->roles = $user->getRoles();
      $data['code'] = $event->getResponse()->getStatusCode();
      $data['data'] = array(
          'roles' => $user->getRoles(),
      );

      $event->setData($data);
  }
}
