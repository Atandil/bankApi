<?php
use App\Transaction;
use App\User;
use Firebase\JWT\JWT;

class ApiTest extends TestCase
{

    private $token;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        Transaction::create(['customer_id'=>1,'date'=>'02.01.2019','amount'=>10.53]);
        Transaction::create(['customer_id'=>1,'date'=>'02.01.2019','amount'=>10.53]);
        Transaction::create(['customer_id'=>1,'date'=>'03.01.2019','amount'=>10.53]);
        Transaction::create(['customer_id'=>1,'date'=>'02.01.2019','amount'=>110.53]);
        $this->artisan('db:seed');

        //auth token
        $user=User::find(1);
        $this->token=$this->jwtToken($user);

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
        $this->json('POST', '/customer', ['name' => 'Sally', 'cnp' => 123213123],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(200);
        $this->seeJson([
                'customerId' => 3
            ]);

    }

      /* ● getting a transaction:
        ○ Request: customerId, transactionId
        ○ Response: transactionId, amount, date
      */

    public function testGetTransaction()
    {
        $this->json('GET', '/transaction/1/1',
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'transactionId',
            'amount',
            'date'
        ]);
     }

      /*
        ● getting transaction by filters:
        dd($this->response->getContent());
        ○ Request: customerId, amount, date, offset, limit
        ○ Response: an array of transactions
      */

    public function testGetFilteredTransactions()
    {
        $this->json('GET', '/transaction',['customerId'=>1,'amount'=>10.53,'date'=>'02.01.2019','offset'=>0,'limit'=>2],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(201);



    }
      /*  ● adding a transaction:
        ○ Request: customerId, amount
        ○ Response: transactionId, customerId, amount, date*/
    public function testAddTransaction()
    {
        $this->json('POST', '/transaction', ['customerId' => 1, 'amount'=>10.23],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeJsonStructure([
            'transactionId',
            'customerId',
            'amount',
            'date'
        ]);
    }

    public function testAddTransactionMissingFields()
    {
        $this->json('POST', '/transaction', ['customerId' => 1],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(422);

    }

    public function testAddTransactionBadAmount()
    {
        $this->json('POST', '/transaction', ['customerId' => 1, 'amount'=>'sadsad'],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(422);

    }

    /**
     * @TODO   should be 404
     */
    public function testAddTransactionNonExistingCustomer()
    {
        $this->json('POST', '/transaction', ['customerId' => 434, 'amount'=>10.56],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(422);

    }


      /*
        ● updating a transaction:
        ○ Request: transactionId, amount
        ○ Response: transactionId, customerId, amount, date*/
    public function testEditTransaction()
    {
        $this->json('PATCH', '/transaction/1', ['amount'=>444.88],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        //$this->patch('/transaction/1', ['amount'=>444.88]);
        $this->seeJsonStructure([
            'transactionId',
            'customerId',
            'amount',
            'date'
        ]);
    }

    public function testEditNonExistingTransaction()
    {
        $this->json('PATCH','/transaction/451', ['amount'=>444.88],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(404);

    }

    /**
     * @TODO  non 404 but 422 when invalid/missisng data
    */
    public function testEditTransactionWithBadData()
    {
        $this->json('PATCH','/transaction/451', ['amount'=>'ewqeqw'],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(404);

    }

      /*  ● deleting a transaction:
        ○ Request: trasactionId
        ○ Response: success/fail
     */
    public function testDeleteTransaction()
    {
       $this->delete('/transaction/2',[],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(200);

    }

    public function testDeleteNonExistingTransaction()
    {
        $this->delete('/transaction/4235',[],
            ['HTTP_Authorization' => 'Bearer ' . $this->token]);
        $this->seeStatusCode(404);

    }

    protected function jwtToken(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }


}
