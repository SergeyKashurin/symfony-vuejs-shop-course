<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\EditProductFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product", name="admin_product_")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     *
     */
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(
                ['isDeleted' => false],
                ['id' => 'DESC'],
                50
            );
        return $this->render('admin/product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @Route("/add", name="add")
     */
    public function edit(Request $request, Product $product = null): Response
    {
        $form = $this->createForm(EditProductFormType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            dd($product, $form);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_edit', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(): Response
    {
//        return $this->render('admin/product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
    }
}
