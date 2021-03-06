<?php
namespace Kolesa\Clockwork\Listeners;

use Clockwork\Clockwork;
use Clockwork\Helpers\ServerTiming;
use Phalcon\Mvc\User\Plugin;

/**
 * Listener for Application
 */
class Application extends Base
{
    /**
     * Boot event
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Application $myComponent
     */
    public function boot(\Phalcon\Events\Event $event, $myComponent)
    {
        $this->getClockwork()->timeline()->create('App time')->begin();
    }

    /**
     * Before send response event
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Application $myComponent
     */
    public function beforeSendResponse(\Phalcon\Events\Event $event, $myComponent)
    {
        $clockwork = $this->getClockwork();
        $clockwork->timeline()->event('App time')->end();
        $clockwork->resolveRequest()->storeRequest();

        $this->response->setHeader('X-Clockwork-Id', $clockwork->getRequest()->id);
        $this->response->setHeader('X-Clockwork-Version', Clockwork::VERSION);
        $this->response->setHeader(
            'X-Clockwork-Path',
            "{$this->getDiClockwork()->config->path('api', '/__clockwork')}/"
        );
        $this->response->setHeader('Server-Timing', ServerTiming::fromRequest($clockwork->getRequest())->value());
    }
}