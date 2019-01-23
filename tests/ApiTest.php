<?php


class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        //$this->artisan('db:seed');
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
    }


    /*
     * adding of a customer:
        ○ Request: name, cnp
        ○ Response: customerId
    */
    public function testAddCustomer()
    {
        $this->json('POST', '/customer', ['name' => 'Sally', 'cnp' => 123213123]);
        $this->seeStatusCode(200);

        //dd($this->response->getContent());

        $this->seeJson([
                'customerId' => 1
            ]);

    }

      /* ● getting a transaction:
        ○ Request: customerId, transactionId
        ○ Response: transactionId, amount, date
        ● getting transaction by filters:
        ○ Request: customerId, amount, date, offset, limit
        ○ Response: an array of transactions
        ● adding a transaction:
        ○ Request: customerId, amount
        ○ Response: transactionId, customerId, amount, date
        ● updating a transaction:
        ○ Request: transactionId, amount
        ○ Response: transactionId, customerId, amount, date
        ● deleting a transaction:
        ○ Request: trasactionId
        ○ Response: success/fail
     */
}
