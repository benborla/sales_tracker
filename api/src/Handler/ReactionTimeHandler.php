<?php

namespace App\Handler;

use App\Handler\AbstractEntityHandler;
use App\Entity\User;

class ReactionTimeHandler extends AbstractEntityHandler
{
    /**
     * handle
     *
     * @param \App\Entity\ReactionTime $entity
     * @param \App\Entity\User $currentUser
     * @access public
     * @return void
     */
    public function handle($entity, $currentUser
    ) {
        parent::handle($entity, $currentUser);
    } // End function handle // End function handle
}
