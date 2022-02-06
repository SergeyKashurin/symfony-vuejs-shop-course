<?php

namespace App\Entity;

use App\Repository\ProductImageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductImageRepository::class)
 *  @ApiResource(
 *  collectionOperations={
 *      "get"={
 *          "normalization_context"={"groups"="product_image:list"}
 *       },
 *  },
 *      itemOperations={
 *          "get"={
 *             "normalization_context"={"groups"="product_image:item"}
 *          },
 *     }
 * )
 */
class ProductImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"cart_product:item", "cart_product:list", "cart:item", "cart:list"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filenameBIG;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filenameMiddle;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"cart_product:item", "cart_product:list", "cart:item", "cart:list"})
     */
    private $filenameSmall;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getFilenameBIG(): ?string
    {
        return $this->filenameBIG;
    }

    public function setFilenameBIG(string $filenameBIG): self
    {
        $this->filenameBIG = $filenameBIG;

        return $this;
    }

    public function getFilenameMiddle(): ?string
    {
        return $this->filenameMiddle;
    }

    public function setFilenameMiddle(string $filenameMiddle): self
    {
        $this->filenameMiddle = $filenameMiddle;

        return $this;
    }

    public function getFilenameSmall(): ?string
    {
        return $this->filenameSmall;
    }

    public function setFilenameSmall(string $filenameSmall): self
    {
        $this->filenameSmall = $filenameSmall;

        return $this;
    }
}
