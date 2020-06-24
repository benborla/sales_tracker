<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TesterController extends AbstractController
{
    /**
     * @Route("/dev/tester")
     */
    public function test()
    {
        $roles = $this->getParameter('roles');
        dump($roles);
        die;
    } // End function test
}
