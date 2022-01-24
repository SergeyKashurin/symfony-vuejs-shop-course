<?php

namespace App\Utils\Manager;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ProductManager {

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var string
     */
    private string $productImagesDir;

    /**
     * @var ProductImageManager
     */
    private ProductImageManager $productImageManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductImageManager $productImageManager
     * @param string $productImagesDir
     */
    public function __construct(EntityManagerInterface $entityManager, ProductImageManager $productImageManager, string $productImagesDir)
    {
        $this->entityManager = $entityManager;
        $this->productImagesDir = $productImagesDir;
        $this->productImageManager = $productImageManager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Product::class);
    }

    /**
     * @param Product $product
     */
    public function save(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function remove()
    {
        //
    }

    /**
     * @param Product $product
     * @return string
     */
    public function getProductImagesDir(Product $product)
    {
        return sprintf('%s/%s', $this->productImagesDir, $product->getId());
    }

    public function updateProductImages(Product $product, string $tempImageFilename = null): Product
    {
        if(!$tempImageFilename) {
            return $product;
        }

        $productDir = $this->getProductImagesDir($product);

        $productImage = $this->productImageManager->saveImageForProduct($productDir, $tempImageFilename);
        $productImage->setProduct($product);
        $product->addProductImage($productImage);

        return $product;
    }
    
}