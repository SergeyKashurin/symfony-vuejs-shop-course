<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Category;
use App\Entity\OrderProduct;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Form\Admin\EditOrderFormType;
use App\Form\Handler\OrderFormHandled;
use App\Repository\OrderRepository;
use App\Utils\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order", name="admin_order_")
 */
class OrderController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/list", name="list")
     */
    public function list(OrderRepository $orderRepository): Response
    {

        $orders = $orderRepository->findBy(['isDeleted' => false], ['id' => 'DESC']);
        return $this->render('admin/order/list.html.twig', [
            'orders' => $orders,
            'orderStatusChoices' => OrderStaticStorage::getOrderStatusChoices()
        ]);
    }


    /**
     * @param Request $request
     * @param Category|null $category
     * @return Response
     *
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @Route("/add", name="add")
     */
    public function edit(Request $request, OrderFormHandled $orderFormHandled, Order $order= null): Response
    {

        if(!$order) {
            $order = new Order();
        }

        $form = $this->createForm(EditOrderFormType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $order = $orderFormHandled->processEditForm($order);

            $this->addFlash('success', 'Your changes were saved!');

            return $this->redirectToRoute('admin_order_edit', [
                'id' => $order->getId(),
            ]);
        }

        if($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Something went wrong. Please check your form.');
        }

        $orderProducts = [];
        /**
         * @var OrderProduct $product
         */
        foreach ($order->getOrderProducts()->getValues() as $product) {
            $orderProducts[] = [
              'title' => $product->getProduct()->getTitle(),
              'quantity' => $product->getProduct()->getQuantity(),
            ];

        }

        return $this->render('admin/order/edit.html.twig', [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Order $order
     * @param OrderManager $orderManager
     * @return Response
     *
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(Order $order, OrderManager $orderManager): Response
    {
        $orderManager->remove($order);

        $this->addFlash('warning', 'The order was successfully deleted!');

        return $this->redirectToRoute('admin_order_list');
    }
}
