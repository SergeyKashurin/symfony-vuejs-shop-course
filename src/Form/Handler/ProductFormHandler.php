<?php

namespace App\Form\Handler;

use App\Entity\Product;
use App\Form\DTO\EditProductModel;
use App\Form\EditProductFormType;
use App\Utils\File\FileSaver;
use App\Utils\Manager\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class ProductFormHandler {
    /**
     * @var FileSaver
     */
    private FileSaver $fileSaver;

    /**
     * @var ProductManager
     */
    private ProductManager $productManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param FileSaver $fileSaver
     */
    public function __construct(ProductManager $productManager, FileSaver $fileSaver) {

        $this->productManager = $productManager;
        $this->fileSaver = $fileSaver;
    }

    /**
     * @param EditProductModel $editProductModel
     * @param Form $form
     * @return Product|null
     */
    public function processEditForm(EditProductModel $editProductModel, Form $form)
    {
        $product = new Product();

        if($editProductModel->id)
        {
            $product = $this->productManager->find($editProductModel->id);
        }

        $product->setTitle($editProductModel->title);
        $product->setPrice($editProductModel->price);
        $product->setQuantity($editProductModel->quantity);
        $product->setDescription($editProductModel->description);
        $product->setIsPublished($editProductModel->isPublished);
        $product->setIsDeleted($editProductModel->isDeleted);

        $this->productManager->save($product);

        $newImageFile = $form->get('newImage')->getData();

        $tempImageFilename = $newImageFile
            ? $this->fileSaver->saveUploadedFileIntoTemp($newImageFile)
            : null;


        $this->productManager->updateProductImages($product, $tempImageFilename);

        $this->productManager->save($product);

        return $product;
    }
    
}