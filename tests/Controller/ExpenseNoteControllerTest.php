<?php
namespace APP\tests;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DateTime;
use App\Entity\ExpenseNote;
use App\Entity\User;

class ExpenseNoteControllerTest extends WebTestCase{
    
    public function testApiExpenseNote()
    {
        $client = static::createClient();

        $client->request('GET', '/api/app_expense_note');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testListExpenseNotes()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/expense_notes');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateExpenseNote()
    {
        $client = static::createClient();
       
        $data = [
            'noteDate' => (new DateTime())->format('Y-m-d'), 
            'noteType' => ExpenseNote::TYPE_FUEL,
            'amount' => 99.99,
            'company' => 1,
            'commercial' => 1,
        ];

        $client->request(
            'POST',
            '/api/expense_note',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
 
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShowExpenseNote()
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/expense_note/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateExpenseNote()
    {
        $client = static::createClient();
        
        $data = [
            'noteDate' => (new DateTime())->format('Y-m-d'), 
            'noteType' => ExpenseNote::TYPE_FUEL,
            'amount' => 99.99,
            'company' => 1,
            'commercial' => 1,
        ];

        $client->request(
            'PUT',
            '/api/expense_note/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDeleteExpenseNote()
    {
        $client = static::createClient();
        
        $client->request('DELETE', '/api/expense_note/1');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }


    
}
