<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderCreatedFromCartSendNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @param $event
     */
    public function onOrderCreatedFromCartEvent($event)
    {
        dd($event, 'from subscriber');
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreatedFromCartEvent::class => 'onOrderCreatedFromCartEvent',
        ];
    }
}
