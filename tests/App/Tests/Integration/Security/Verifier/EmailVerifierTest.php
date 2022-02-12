<?php

namespace App\Tests\App\Tests\Integration\Security\Verifier;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 */
class EmailVerifierTest extends KernelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        self:self::bootKernel();
        $userRepository = self::$container->get(UserRepository::class);
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }
}
