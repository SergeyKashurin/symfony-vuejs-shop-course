<?php

namespace App\Controller\Main;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmbedController extends AbstractController
{

    /**
     * @param ProductRepository $productRepository
     * @param int $productCount
     * @param int $categoryId
     * @return Response
     */
    public function showSimilarProducts(ProductRepository $productRepository, int $productCount = 2, int $categoryId = null): Response
    {

        $params = [];

        if($categoryId) {
            $params['category'] = $categoryId;
        }

        $products = $productRepository->findBy($params, ['id' => 'DESC'], $productCount);

        return $this->render('main/_embed/_similar_products.html.twig', [
            'products' => $products,
        ]);
    }
}
