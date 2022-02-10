<?php

namespace App\EventSubscriber;

use App\Utils\Mailer\Sender\OrderCreatedFromCartEmailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderCreatedFromCartSendNotificationSubscriber implements EventSubscriberInterface
{

    /**
     * @var OrderCreatedFromCartEmailSender
     */
    private OrderCreatedFromCartEmailSender $orderCreatedFromCartEmailSender;

    /**
     * @param OrderCreatedFromCartEmailSender $orderCreatedFromCartEmailSender
     */
    public function __construct(OrderCreatedFromCartEmailSender $orderCreatedFromCartEmailSender)
    {

        $this->orderCreatedFromCartEmailSender = $orderCreatedFromCartEmailSender;
    }

    /**
     * @param $event
     */
    public function onOrderCreatedFromCartEvent($event)
    {
        $order = $event->getOrder();

        $this->orderCreatedFromCartEmailSender->sendEmailToClient($order);
        $this->orderCreatedFromCartEmailSender->sendEmailToManager($order);
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
