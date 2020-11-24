<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class MainControllerTest extends WebTestCase
{

    public function testIfRedirects()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $this->assertResponseRedirects('/login');
    }

    public function testIfLoggedInUsersHasAccess()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => 'asdf@asdf.asdf']);

        $client->loginUser($testUser);

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }
}