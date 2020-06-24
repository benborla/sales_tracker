<?php

namespace App\Controller;

use App\Entity\TrackingTraining;
use App\Handler\TrackingTrainingHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateTrackingTraining extends AbstractController
{
    private $handler;

    public function __construct(TrackingTrainingHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * __invoke
     *
     * @param \App\Entity\TrackingTraining $data
     * @access public
     * @return void
     */
    public function __invoke(TrackingTraining $data)
    {
        $this->handler->handle($data, $this->getUser());

        return $data;
    } // End function __invoke // End function __invoke
}
