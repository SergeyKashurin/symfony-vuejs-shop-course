<?php

namespace App\Tests\Functional\ApiPlatform;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Tests\TestUtils\Fixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ProductResourceTest extends WebTestCase
{

    /**
     * @var string
     */
    protected $uriKey = '/api/products';

    public const REQUEST_HEADERS = [
        'HTTP_ACCEPT' => 'application/ld+json',
        'CONTENT_TYPE' => 'application/json',
    ];

    public function testGetProducts()
    {
        $client = static::createClient();
        $client->request('GET', $this->uriKey, [], [], static::REQUEST_HEADERS);

        #dd(json_decode($client->getResponse()->getContent()));
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetProduct()
    {
        $client = static::createClient();

        /** @var Product $product */
        $product = static::$container->get(ProductRepository::class)->findOneBy([]);

        $uri = $this->uriKey.'/'.$product->getUuId();

        $client->request('GET', $uri, [], [], static::REQUEST_HEADERS);
        #dd(json_decode($client->getResponse()->getContent()));
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateProduct()
    {
        $client = static::createClient();

        $this->checkDefaultUserHasNotAccess($client, $this->uriKey, 'POST');

        $user = static::$container->get(UserRepository::class)->findOneBy(['email' => UserFixtures::USER_ADMIN_1_EMAIL]);

        $client->loginUser($user, 'main');

        $context = [
            'title' => 'New product',
            'price' => '100',
            'quantity' => 3,
            'description' => 'some description',
        ];

        $client->request('POST', $this->uriKey, [], [], static::REQUEST_HEADERS, json_encode($context));

        $this->assertResponseStatusCodeSame(201);
    }

    public function checkDefaultUserHasNotAccess(AbstractBrowser $client, string $uri, string $method)
    {
        $user = static::$container->get(UserRepository::class)->findOneBy(['email' => UserFixtures::USER_1_EMAIL]);
        $client->loginUser($user, 'main');

        $client->request($method, $uri, [], [], static::REQUEST_HEADERS, json_encode([]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function getResponseDecodeContent(AbstractBrowser $client)
    {
        return json_decode(
            $client->getResponse()->getContent()
        );
    }
}