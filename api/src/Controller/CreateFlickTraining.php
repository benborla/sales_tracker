<?php

namespace App\Controller;

use App\Entity\FlickTraining;
use App\Handler\FlickTrainingHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateFlickTraining extends AbstractController
{
    private $handler;

    public function __construct(FlickTrainingHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * __invoke
     *
     * @param \App\Entity\FlickTraining $data
     * @access public
     * @return void
     */
    public function __invoke(FlickTraining $data)
    {
        $this->handler->handle($data, $this->getUser());

        return $data;
    } // End function __invoke
}
