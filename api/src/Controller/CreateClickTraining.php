<?php

namespace App\Controller;

use App\Entity\ClickTraining;
use App\Handler\ClickTrainingHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateClickTraining extends AbstractController
{
    private $handler;

    public function __construct(ClickTrainingHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * __invoke
     *
     * @param \App\Entity\ClickTraining $data
     * @access public
     * @return void
     */
    public function __invoke(ClickTraining $data)
    {
        $this->handler->handle($data, $this->getUser());

        return $data;
    } // End function __invoke
}
