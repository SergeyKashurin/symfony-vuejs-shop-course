<?php

namespace App\Form\Handler;

use App\Entity\Order;
use App\Form\DTO\EditCategoryModel;
use App\Utils\Manager\OrderManager;

class OrderFormHandled
{
    /**
     * @var CategoryManager
     */
    private $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * @param Order $order
     * @return Order|object|null
     */
    public function processEditForm(Order $order)
    {

        $this->orderManager->save($order);

        return $order;
    }
}