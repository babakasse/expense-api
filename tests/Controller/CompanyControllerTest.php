<?php
namespace APP\tests;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DateTime;

class CompanyControllerTest extends WebTestCase{
    
    public function testApiCompany()
    {
        $client = static::createClient();

        $client->request('GET', '/api/app_company');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testListCompanys()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/companies');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateCompany()
    {
        $client = static::createClient();
       
        $data = [
            'name' => 'KISS THE BRIDE', 
        ];

        $client->request(
            'POST',
            '/api/company',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
 
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShowCompany()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/company/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateCompany()
    {
        $client = static::createClient();
        
        $data = [
            'name' => 'CELESTA ENGIINEERING',
        ];

        $client->request(
            'PUT',
            '/api/company/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDeleteCompany()
    {
        $client = static::createClient();
        
        $client->request('DELETE', '/api/company/1');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }


    
}
