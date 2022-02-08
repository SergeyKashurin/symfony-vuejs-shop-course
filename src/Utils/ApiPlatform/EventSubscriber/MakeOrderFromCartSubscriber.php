<?php

namespace App\Utils\ApiPlatform\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Entity\User;
use App\Utils\Manager\OrderManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class MakeOrderFromCartSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var OrderManager
     */
    private OrderManager $orderManager;

    /**
     * @param Security $security
     * @param OrderManager $orderManager
     */
    public function __construct(Security $security, OrderManager $orderManager)
    {

        $this->security = $security;
        $this->orderManager = $orderManager;
    }

    /**
     * @param ViewEvent $event
     */
    public function makeOrder(ViewEvent $event)
    {
        $order = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$order instanceof Order || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var User $user */
        $user = $this->security->getUser();

        if(!$user) {
            return;
        }

        $order->setOwner($user);
        $contentJson = $event->getRequest()->getContent();

        if(!$contentJson) {
            return;
        }

        $content = json_encode($contentJson, true);
        if(!array_key_exists('cartId', $content)) {
            return;
        }

        $cartId = (int)$content['cartId'];
        $this->orderManager->addOrderProductsFromCart($order, $cartId);
        $this->orderManager->recalculateOrderTotalPrice($order);
        $order->setStatus(OrderStaticStorage::ORDER_STATUS_CREATED);
    }

    /**
     * @return \array[][]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                [
                    'makeOrder', EventPriorities::PRE_WRITE
                ]
            ]
        ];
    }
}
