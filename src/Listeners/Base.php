<?php
namespace Kolesa\Clockwork\Listeners;

use Phalcon\Mvc\User\Plugin;

/**
 * Abstract class for Listeners
 */
abstract class Base extends Plugin
{
    /**
     * Get cloсkwork
     *
     * @return \Clockwork\Clockwork
     */
    protected function getClockwork()
    {
        return $this->getDiClockwork()->getClockwork();
    }

    /**
     * @return \Kolesa\Clockwork\ClockworkSupport
     */
    protected function getDiClockwork()
    {
        return $this->di->get('clockwork');
    }
}
