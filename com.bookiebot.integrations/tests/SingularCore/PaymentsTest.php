<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentsTestCase extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    //TODO GetBalance Check
    public function testGetBalance() {
        $this->assertTrue(true);
    }


    //TODO Withdraw Money With Error Response and check blance
    public function withdrawMoneyWithError() {
        $this->assert(true);
    }
    

    //TODO Withdraw Money and check balance
    public function withdfrawMoney() {
        $this->assert(true);
    }



    //TODO Deposit Money with Error Response and check balance



    //TODO Deposit Money and check balance




    //TODO Deposit and then rollback and then check balance




    //TODO Withdraw and the rollback and then check balance




    //TODO Deposit Failed with Generic Error Case should check 3 second wait





}
