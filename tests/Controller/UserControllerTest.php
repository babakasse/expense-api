<?php
namespace APP\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DateTime;

class UserControllerTest extends WebTestCase{
    
    public function testApiUser()
    {
        $client = static::createClient();

        $client->request('GET', '/api/app_user');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testListUsers()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateUser()
    {
        $client = static::createClient();
        $data = [
            'username' => 'johndoe',
            'password' => 'johndopassword',
            'email' => 'johndoe@test.fr',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'dateOfBirth' => (new DateTime())->format('Y-m-d'),
        ];

        $client->request(
            'POST',
            '/api/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShowUser()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/user/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}
