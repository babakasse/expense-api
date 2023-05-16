<?php
namespace APP\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends WebTestCase{
    
    public function testListUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/api/user');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    
}
