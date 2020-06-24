<?php

namespace App\Controller;

use App\Entity\ReactionTime;
use App\Handler\ReactionTimeHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateReactionTime extends AbstractController
{
    private $handler;

    public function __construct(ReactionTimeHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * __invoke
     *
     * @param \App\Entity\ReactionTime $data
     * @access public
     * @return \App\Entity\ReactionTime
     */
    public function __invoke(ReactionTime $data)
    {
        $this->handler->handle($data, $this->getUser());

        return $data;
    } // End function __invoke
}
